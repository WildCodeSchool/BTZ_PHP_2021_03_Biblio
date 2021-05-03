<?php

namespace App\DataFixtures;

use App\Entity\Language;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class LanguageFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $csvFile = file(__DIR__.'./../../database/language.csv');

        $languageArray = [];
        foreach ($csvFile as $line) {
            $languageArray[] = str_getcsv($line);
        }
        $i = 0;
        foreach ($languageArray as $data) {
            if ($i > 0) {
                $data =  explode(";", $data[0]);
                $language = new language();
                $language->setName($data[1]);
                $this->addReference('language_' . $data[0], $language);
                $manager->persist($language);
            }
            $i++;
        }

        $manager->flush();
    }
}
