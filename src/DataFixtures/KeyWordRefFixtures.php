<?php

namespace App\DataFixtures;

use App\Entity\KeywordRef;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class KeyWordRefFixtures extends Fixture
{
    protected $slugify;

    public function __construct(Slugify $slugify)
    {
        $this->slugify = $slugify;
    }

    public function load(ObjectManager $manager)
    {
        $csvFile = file(__DIR__.'./../../database/keywordref.csv');

        $keywordRefArray = [];
        foreach ($csvFile as $line) {
            $keywordRefArray[] = str_getcsv($line);
        }
        $i = 0;
        $slugTab= [];
        foreach ($keywordRefArray as $data) {
            if ($i > 0) {
                $data =  explode(";", $data[0]);
                $keywordRef = new KeywordRef();
                $slug = $this->slugify->generate($data[1]);
                
                if (!in_array($slug, $slugTab)) {
                    $keywordRef->setName($data[1]);
                    $keywordRef->setSlug($slug);
                    $this->addReference('keywordref_' . $slug, $keywordRef);
                    $manager->persist($keywordRef);
                    $slugTab[] = $slug;
                } else {
                    // echo "doublon $slug \n";
                }
            }
            $i++;
        }

        $manager->flush();
    }
}
