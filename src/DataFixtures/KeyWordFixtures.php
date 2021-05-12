<?php

namespace App\DataFixtures;

use App\Entity\Keyword;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;


class KeyWordFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        ini_set("auto_detect_line_endings", true);
        $faker = Faker\Factory::create('fr_FR');
        $csvFile = file(__DIR__.'./../../database/keyword.csv');

        $keywordArray = [];
        foreach ($csvFile as $line) {
            $keywordArray[] = str_getcsv($line);
        }
    $j=0;
        foreach ($keywordArray as $data) {
            if ($j > 0) {
                $data = explode(';', $data[0]);

                $publication = $this->getReference('publication_'.$data[2]);
                $notice = $this->getReference('notice_'.$data[1]);

                for ($i = 3; $i < 8; ++$i) {
                    $keyword = new keyword();
                    if ($data[$i]) {
                        $keyword->setName(trim($data[$i]));

                        $keyword->setPublication($publication);

                        if ($i < 7) {
                            $keyword->setGeolocalisation(false);
                        } else {
                            $keyword->setGeolocalisation(true);
                        }

                        $this->addReference('keyword_'.$data[0].'_'.$i, $keyword);
                        $manager->persist($keyword);
                    }
                }
            }
            $j++;
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            PublicationFixtures::class,
        ];
    }
}
