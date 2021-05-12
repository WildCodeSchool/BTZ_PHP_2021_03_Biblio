<?php

namespace App\DataFixtures;

use App\Entity\KeywordGeo;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class KeywordGeoFixtures extends Fixture
{
    protected $slugify;

    public function __construct(Slugify $slugify)
    {
        $this->slugify = $slugify;
    }

    public function load(ObjectManager $manager)
    {
        $csvFile = file(__DIR__.'./../../database/keywordGeo.csv');

        $keywordGeoArray = [];
        foreach ($csvFile as $line) {
            $keywordGeoArray[] = str_getcsv($line);
        }
        $i = 0;
        foreach ($keywordGeoArray as $data) {
            if ($i > 0) {
                $data =  explode(";", $data[0]);
                $keywordGeo = new KeywordGeo();
                $keywordGeo->setName($data[1]);
                $slug = $this->slugify->generate($data[1]);
                $keywordGeo->setSlug($slug);
                $this->addReference('keywordGeo_' . $data[0], $keywordGeo);
                $manager->persist($keywordGeo);
            }
            $i++;
        }

        $manager->flush();
    }
}
