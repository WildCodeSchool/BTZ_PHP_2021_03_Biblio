<?php

namespace App\DataFixtures;
use App\Entity\Author;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $faker = Faker\Factory::create('fr_FR');

        // for($i = 0; $i < 10; $i++){
        //     $author = new Author();
        //     // $author->setName();
        //     // $author->setAddress();
        // }

        // $manager->flush();
    }
}
