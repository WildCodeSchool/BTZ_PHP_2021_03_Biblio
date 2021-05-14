<?php

namespace App\DataFixtures;

use App\Entity\Keyword;
use App\Entity\KeywordRef;
use App\Entity\KeywordGeo;
use App\Entity\Publication;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class KeyWordFixtures extends Fixture implements DependentFixtureInterface
{
    protected $slugify;

    public function __construct(Slugify $slugify)
    {
        $this->slugify = $slugify;
    }
    
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

                for ($i = 3; $i < 8; ++$i) {
                    $keyword = new Keyword();
                    if ($data[$i]) {
                        $word = trim($data[$i]);
                        $slug = $this->slugify->generate($word);
                        $keyword->setName($word);
                        $keyword->setSlug($slug);
                        $keyword->setPublication($publication);
                        if ($slug !== '') {
                            if ($i < 7) {
                                $keywordRef = $this->getReference('keywordref_'.$slug);
                                $keywordRef->addPublication($publication);
                                $publication->addKeywordRef($keywordRef);
                                $keyword->setGeolocalisation(false);
                            } else {
                                $keywordGeo = $this->getReference('keywordgeo_'.$slug);
                                $keywordGeo->addPublication($publication);
                                $publication->addKeywordGeo($keywordGeo);
                                $keyword->setGeolocalisation(true);
                            }
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
            KeyWordRefFixtures::class,
            KeyWordGeoFixtures::class
        ];
    }
}
