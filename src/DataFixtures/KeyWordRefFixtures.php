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
        $csvFile = file(__DIR__.'./../../database/keywordRef.csv');

        $keywordRefArray = [];
        foreach ($csvFile as $line) {
            $keywordRefArray[] = str_getcsv($line);
        }
        $i = 0;
        foreach ($keywordRefArray as $data) {
            if ($i > 0) {
                $data =  explode(";", $data[0]);
                $keywordRef = new KeywordRef();
                $keywordRef->setName($data[0]);
                $slug = $this->slugify->generate($data[0]);
                $keywordRef->setSlug($slug);
                $this->addReference('KeywordRef_' . $data[0], $keywordRef);
                $manager->persist($keywordRef);
            }
            $i++;
        }

        $manager->flush();
    }
}
