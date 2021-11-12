<?php

namespace App\DataFixtures;

use App\Entity\Item;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ItemFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $item = new Item();
        $item
            ->setName('stationary')
            ->setMinWeight(0.1)
            ->setMaxWeight(1)
        ;
        $manager->persist($item);
        $manager->flush();

        $item = new Item();
        $item
            ->setName('printers')
            ->setMinWeight(2.5)
            ->setMaxWeight(2.5)
        ;
        $manager->persist($item);
        $manager->flush();

        $item = new Item();
        $item
            ->setName('furniture')
            ->setMinWeight(4)
            ->setMaxWeight(50)
        ;
        $manager->persist($item);
        $manager->flush();
    }

    /**
     * @return int
     */
    public function getOrder(): int
    {
        return 2;
    }
}
