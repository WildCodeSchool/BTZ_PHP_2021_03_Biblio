<?php

namespace App\DataFixtures;

use App\Entity\Publication;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PublicationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        ini_set("auto_detect_line_endings", true);
        $csvFile = file(__DIR__.'./../../database/publication.csv');
        $i = 0;
        foreach ($csvFile as $line) {
            $data = str_getcsv($line);
            echo $i;
            if ($i > 0) {
                $data =  explode(";", $data[0]);
                // var_dump($data);
                $publication = new Publication();
                // $slug = $this->slugify->generate($data[0]);
                // $publication->setSlug($slug);
                echo '-----' . $i . "----";
                var_dump($data);
                $datePub = str_replace('/', '-', $data[7]);
                $datePub =  date('Y-m-d', strtotime($datePub));
                $datePub = new DateTime($datePub);
                $publication->setType($this->getReference('type_' . $data[1]));
                $publication->setThematic($this->getReference('thematic_' . $data[2]));
                $publication->setTitle($data[3]);
                $publication->addAuthor($this->getReference('author_' . $data[4]));
                $publication->addEditor($this->getReference('editor_' . $data[5]));
                $publication->setMention($data[6]);
                $publication->setPublicationDate($datePub);
                $publication->setPaging(intval($data[8]));
                $publication->setVolumeNumber($data[9]);
                $publication->setBookcollection($this->getReference('collection_' . $data[10]));
                $publication->setLanguage($this->getReference('language_' . $data[11]));
                $publication->setIssnIsbn($data[12]);
                $publication->setSupport($data[13]);
                $publication->setSourceAddress($data[14]);
                $publication->setUrl($data[15]);
                $publication->setLocalisation($this->getReference('localisation_' . $data[16]));
                $publication->setCote($data[17]);
                $publication->setSummary($data[18]);
                $this->addReference('publication_' . $data[0], $publication);
                $manager->persist($publication);
            }
            $i++;
        };

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            PublicationTypeFixtures::class,
            LocalisationFixtures::class,
            ThematicFixtures::class,
            BookCollectionFixtures::class,
            LanguageFixtures::class
        ];
    }
}
