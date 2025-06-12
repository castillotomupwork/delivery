<?php

namespace App\Controller;

use App\Entity\Delivery;
use App\Entity\ItemDelivery;
use App\Repository\ItemRepository;
use App\Repository\TransportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ApiController
 *
 * @Route("/api", name="api")
 * @package App\Controller
 */
class ApiController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var ItemRepository
     */
    private $itemRepository;

    /**
     * @var TransportRepository
     */
    private $transportRepository;

    /**
     * ApiController constructor.
     *
     * @param EntityManagerInterface $entityManager
     * @param ItemRepository $itemRepository
     * @param TransportRepository $transportRepository
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        ItemRepository $itemRepository,
        TransportRepository $transportRepository
    ) {
        $this->entityManager = $entityManager;
        $this->itemRepository = $itemRepository;
        $this->transportRepository = $transportRepository;
    }

    /**
     * @Route("/items", name="_get_items", methods={"GET"})
     *
     * @return JsonResponse
     *
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function getItems(): JsonResponse
    {
        $items = $this->itemRepository->findAll();

        $data = [];
        foreach ($items as $item) {
            $data[] = [
                'id' => $item->getId(),
                'name' => $item->getName(),
                'minWeight' => $item->getMinWeight(),
                'maxWeight' => $item->getMaxWeight()
            ];
        }

        return new JsonResponse(['items' => $data, 'status' => 'success']);
    }

    /**
     * @Route("/estimate", name="_estimate_delivery", methods={"POST"})
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function estimateDelivery(Request $request): JsonResponse
    {
        if ($request->getContentType() != 'json') {
            return new JsonResponse(['message' => 'Invalid content type', 'status' => 'error']);
        }

        $requestData = $request->toArray();

        $data = $this->calculateDelivery($requestData);

        if ($data instanceof JsonResponse) {
            return $data;
        }

        return new JsonResponse(['delivery' => $data['delivery'], 'item_delivery' => $data['item_delivery'],
            'status' => 'success']);
    }

    /**
     * @Route("/book/{id}", name="_book_delivery", methods={"POST"})
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function bookDelivery(Request $request, $id): JsonResponse
    {
        if ($request->getContentType() != 'json') {
            return new JsonResponse(['message' => 'Invalid content type', 'status' => 'error']);
        }

        $requestData = $request->toArray();

        $data = $this->calculateDelivery($requestData, $id);

        if (isset($data['error']) && $data['error'] === true) {
            return new JsonResponse(['message' => 'Please click Estimate Transport button.', 'status' => 'error']);
        }

        $delivery = new Delivery();
        $delivery
            ->setTransport($data['delivery']['transport'])
            ->setAddress($data['delivery']['address'])
            ->setTotalWeight($data['delivery']['total_weight'])
            ->setDistance($data['delivery']['distance'])
            ->setPrice($data['delivery']['price'])
        ;
        $this->entityManager->persist($delivery);
        $this->entityManager->flush();

        foreach ($data['item_delivery'] as $item) {
            $currentItem = $this->itemRepository->findOneBy(['id' => $item['id']]);

            $itemDelivery = new ItemDelivery();
            $itemDelivery
                ->setItem($currentItem)
                ->setDelivery($delivery)
                ->setWeight($item['value'])
            ;
            $this->entityManager->persist($itemDelivery);
            $this->entityManager->flush();
        }

        return new JsonResponse(['message' => 'Order has been booked.', 'status' => 'success']);
    }

    /**
     * @param $requestData
     * @param int $transportId
     *
     * @return array|JsonResponse
     */
    private function calculateDelivery($requestData, $transportId = 0)
    {
        $data = [];
        $totalWeight = 0;
        $totalDistance = 0;
        foreach ($requestData as $inputKey => $val) {
            if (preg_match('/^item/', $inputKey)) {
                $itemId = substr($inputKey, 5);
                $itemId = substr($itemId, 0, -1);

                $data['item_delivery'][] = ['name' => 'item', 'id' => $itemId, 'value' => $val];

                $totalWeight = $totalWeight + $val;

                $item = $this->itemRepository->findOneBy(['id' => $itemId]);

                if ($val < $item->getMinWeight()) {
                    return new JsonResponse(['message' => 'Didn\'t reached minimum weight for ' . $item->getName() . ' item.',
                        'status' => 'error']);
                }

                if ($val > $item->getMaxWeight()) {
                    return new JsonResponse(['message' => 'Item ' . $item->getName() . ' exceed maximum weight limit.',
                        'status' => 'error']);
                }

            } else {
                if ($inputKey == 'distance') {
                    $totalDistance = $totalDistance + $val;
                }

                if ($inputKey == 'address') {
                    $address = $val;
                }
            }
        }

        if ($transportId == 0) {
            $transports = $this->transportRepository->findAll();

            foreach ($transports as $transport) {
                $message = '';
                $price = 0;
                $setPrice = true;
                $weight = $totalWeight;
                if ($totalWeight > $transport->getWeightLimit()) {
                    $message = 'Package exceeds ' . $transport->getWeightLimit() . 'kg limit.';
                    $setPrice = false;
                }

                $distance = $totalDistance;
                if ($totalDistance > $transport->getDistanceLimit()) {
                    $message = 'Distance exceeds ' . $transport->getDistanceLimit() . 'km limit.';
                    $setPrice = false;
                }

                if ($setPrice === true) {
                    $price = $transport->getDistancePrice() * round($totalDistance);
                }

                $data['delivery'][] = [
                    'id' => $transport->getId(),
                    'name' => $transport->getName(),
                    'address' => $address,
                    'total_weight' => $weight,
                    'distance' => $distance,
                    'price' => $price,
                    'message' => $message,
                ];
            }
        } else {
            $transport = $this->transportRepository->findOneBy(['id' => $transportId]);

            $message = '';
            $price = 0;
            $setPrice = true;
            $weight = $totalWeight;
            if ($totalWeight > $transport->getWeightLimit()) {
                $message = 'Package exceeds ' . $transport->getWeightLimit() . 'kg limit.';
                $setPrice = false;
            }

            $distance = $totalDistance;
            if ($totalDistance > $transport->getDistanceLimit()) {
                $message = 'Distance exceeds ' . $transport->getDistanceLimit() . 'km limit.';
                $setPrice = false;
            }

            if ($setPrice === true) {
                $price = $transport->getDistancePrice() * round($totalDistance);
            }

            $data['delivery'] = [
                'transport' => $transport,
                'address' => $address,
                'total_weight' => $weight,
                'distance' => $distance,
                'price' => $price,
                'message' => $message,
            ];
        }

        return $data;
    }
}