<?php

namespace App\DataFixtures;

use App\Entity\Author;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class AuthorFixtures extends Fixture
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
                $author = new Author();
                if (strpos($data[1], '|')) {
                    $authorNames = explode('|', $data[1]);
                    $author->setName(trim($authorNames[0]));
                } else {
                    $author->setName(trim($data[1]));
                }
                
                // $author->setAddress($faker->address);
                $this->addReference('author_' . $data[0], $author);
                $manager->persist($author);
            }
            $i++;
        }
        $manager->flush();
    }
}
