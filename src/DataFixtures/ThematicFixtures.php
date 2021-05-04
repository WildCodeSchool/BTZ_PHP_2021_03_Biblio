<?php

namespace App\DataFixtures;

use App\Entity\Thematic;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ThematicFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $csvFile = file(__DIR__.'./../../database/thematic.csv');

        $thematicArray = [];
        foreach ($csvFile as $line) {
            $thematicArray[] = str_getcsv($line);
        }
        $i = 0;
        foreach ($thematicArray as $data) {
            if ($i > 0) {
                $data =  explode(";", $data[0]);
                $thematic = new Thematic();
                $thematic->setName($data[1]);
                $this->addReference('thematic_' . $data[0], $thematic);
                $manager->persist($thematic);
            }
            $i++;
        }

        $manager->flush();
    }

    // public function getDependencies()
    // {
    //     return [
    //         ThesaurusFixtures::class
    //     ];
    // }
}
