<?php

namespace App\DataFixtures;

use App\Entity\Author;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class AuthorFixtures2 extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        ini_set("auto_detect_line_endings", true);
        $faker = Faker\Factory::create('fr_FR');
        $csvFile = file(__DIR__.'./../../database/author.csv');

        $authorArray = [];
        foreach ($csvFile as $line) {
            $authorArray[] = str_getcsv($line);
        }
        $i = 0;
        foreach ($authorArray as $data) {
            if ($i > 0) {
                $data =  explode(";", $data[0]);
                $authors = explode('|', $data[1]);
                
                if (count($authors) > 1) {
                    $publication = $this->getReference('publication_' . $data[3]);
                    $j = 0;
                    foreach ($authors as $authorName) {
                        if ($i > 0) {
                            $author = new Author();
                            $author->setName(trim($authorName));
                            // $author->setAddress($faker->address);
                            $author->addPublication($publication);
                            $this->addReference('author_' . $data[0] .'_' . $j, $author);
                            $manager->persist($author);
                        }
                        $j++;
                    }
                }
            }
            $i++;
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
