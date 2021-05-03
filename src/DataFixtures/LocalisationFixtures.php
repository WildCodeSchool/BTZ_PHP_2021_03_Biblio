<?php

namespace App\DataFixtures;

use App\Entity\Localisation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class LocalisationFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        ini_set("auto_detect_line_endings", true);
        $csvFile = file(__DIR__.'./../../database/localisation.csv');

        $localisationArray = [];
        foreach ($csvFile as $line) {
            $localisationArray[] = str_getcsv($line);
        }
        $i = 0;
        foreach ($localisationArray as $data) {
            if ($i > 0) {
                $data =  explode(";", $data[0]);
                $localisation = new Localisation();
                $localisation->setName($data[1]);
                $this->addReference('localisation_' . $data[0], $localisation);
                $manager->persist($localisation);
            }
            $i++;
        }

        $manager->flush();
    }
}
