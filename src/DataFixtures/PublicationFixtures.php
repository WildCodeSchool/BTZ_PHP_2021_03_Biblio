<?php

namespace App\DataFixtures;

use App\Entity\Publication;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PublicationFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $csvFile = file(__DIR__.'./../../database/publication.csv');

        $publicationsArray = [];
        foreach ($csvFile as $line) {
            $publicationsArray[] = str_getcsv($line);
        }

        foreach ($publicationsArray as $data) {
            // echo implode(",", $data);
            $publication = new Publication();
            $slug = $this->slugify->generate($data[0]);
            $publication->setSlug($slug);
            $publication->setTitle($data[0]);
            $publication->setSummary($data[1]);
            $publication->setCategory($this->getReference('categorie_'.$data[3]));
            $this->addReference($data[0], $publication);
            $manager->persist($publication);
        }

        $manager->flush();
    }
}
