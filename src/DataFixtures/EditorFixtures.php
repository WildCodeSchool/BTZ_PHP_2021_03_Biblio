<?php

namespace App\DataFixtures;

use App\Entity\Editor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class EditorFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $csvFile = file(__DIR__.'./../../database/editor.csv');

        $editorArray = [];
        foreach ($csvFile as $line) {
            $editorArray[] = str_getcsv($line);
        }
        $i = 0;
        foreach ($editorArray as $data) {
            if ($i > 0) {
                $data =  explode(";", $data[0]);
                $editor = new Editor();
                $editor->setName($data[1]);
                $this->addReference('editor_' . $data[0], $editor);
                $manager->persist($editor);
            }
            $i++;
        }

        $manager->flush();
    }
}
