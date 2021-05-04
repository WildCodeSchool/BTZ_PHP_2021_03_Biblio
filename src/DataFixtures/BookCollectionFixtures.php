<?php

namespace App\DataFixtures;

use App\Entity\BookCollection;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class BookCollectionFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $csvFile = file(__DIR__.'./../../database/collection.csv');

        $bookCollectionArray = [];
        foreach ($csvFile as $line) {
            $bookCollectionArray[] = str_getcsv($line);
        }
        $i = 0;
        foreach ($bookCollectionArray as $data) {
            if ($i > 0) {
                $data =  explode(";", $data[0]);
                $bookCollection = new BookCollection();
                $bookCollection->setName($data[1]);
                $this->addReference('collection_' . $data[0], $bookCollection);
                $manager->persist($bookCollection);
            }
            $i++;
        }
        $manager->flush();
    }
}
