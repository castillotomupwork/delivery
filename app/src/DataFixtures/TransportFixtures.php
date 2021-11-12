<?php

namespace App\DataFixtures;

use App\Entity\Transport;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TransportFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $transport = new Transport();
        $transport
            ->setName('trucks')
            ->setWeightLimit('500')
            ->setDistanceLimit('500')
            ->setDistancePrice('25')
        ;
        $manager->persist($transport);
        $manager->flush();

        $transport = new Transport();
        $transport
            ->setName('cars')
            ->setWeightLimit('100')
            ->setDistanceLimit('50')
            ->setDistancePrice('5')
        ;
        $manager->persist($transport);
        $manager->flush();

        $transport = new Transport();
        $transport
            ->setName('bikes')
            ->setWeightLimit('20')
            ->setDistanceLimit('10')
            ->setDistancePrice('1')
        ;
        $manager->persist($transport);
        $manager->flush();
    }

    /**
     * @return int
     */
    public function getOrder(): int
    {
        return 1;
    }
}
