<?php

namespace App\DataFixtures;

use App\Entity\KeywordGeo;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class KeyWordGeoFixtures extends Fixture
{
    protected $slugify;

    public function __construct(Slugify $slugify)
    {
        $this->slugify = $slugify;
    }

    public function load(ObjectManager $manager)
    {
        $csvFile = file(__DIR__.'./../../database/keywordgeo.csv');

        $keywordGeoArray = [];
        foreach ($csvFile as $line) {
            $keywordGeoArray[] = str_getcsv($line);
        }
        $i = 0;
        $slugTab= [];
        foreach ($keywordGeoArray as $data) {
            if ($i > 0) {
                $data =  explode(";", $data[0]);
                $keywordGeo = new KeywordGeo();
                $slug = $this->slugify->generate($data[1]);
                
                if (!in_array($slug, $slugTab)) {
                    $keywordGeo->setSlug($slug);
                    $keywordGeo->setName($data[1]);
                    $this->addReference('keywordgeo_' . $slug, $keywordGeo);
                    $manager->persist($keywordGeo);
                    $slugTab[] = $slug;
                } else {
                    echo "doublon $slug \n";
                }
            }
            $i++;
        }

        $manager->flush();
    }
}
