<?php

namespace App\DataFixtures;

use App\Entity\Notice;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class NoticeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $csvFile = file(__DIR__.'./../../database/notice.csv');

        $noticeArray = [];
        foreach ($csvFile as $line) {
            $noticeArray[] = str_getcsv($line);
        }
        $i = 0;
        foreach ($noticeArray as $data) {
            if ($i > 0) {
                $data =  explode(";", $data[0]);
                $notice = new Notice();
                $dateNew = str_replace('/', '-', $data[4]);
                $dateNew =  date('Y-m-d', strtotime($dateNew));
                $dateCreation = new DateTime($dateNew);
                $notice->setPublication($this->getReference('publication_' . $data[1]));
                $notice->setAuthor($this->getReference('author_' . $data[2]));
                $notice->setSummary($data[5]);
                $notice->setCreationDate($dateCreation);
                $this->addReference('notice_' . $data[0], $notice);
                $manager->persist($notice);
            }
            $i++;
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            PublicationFixtures::class,
            AuthorFixtures::class,
            AuthorFixtures2::class,
            UserFixtures::class
        ];
    }
}
