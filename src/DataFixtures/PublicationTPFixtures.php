<?php

namespace App\DataFixtures;

use App\Entity\PublicationTP;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PublicationTPFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $csvFile = file(__DIR__.'./../../database/publication_type.csv');

        $publicationTypesArray = [];
        foreach ($csvFile as $line) {
            $publicationTypesArray[] = str_getcsv($line);
        }
        $i = 0;
        foreach ($publicationTypesArray as $data) {
            if ($i > 0) {
                $data =  explode(";", $data[0]);
                $publicationTP = new PublicationTP();
                $publicationTP->setName($data[1]);
                $this->addReference('type_' . $data[0], $publicationTP);
                $manager->persist($publicationTP);
            }
            $i++;
        }

        $manager->flush();
    }
}
