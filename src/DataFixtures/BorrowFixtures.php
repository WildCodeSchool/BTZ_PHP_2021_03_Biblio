<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\User;
use App\Entity\Borrow;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class BorrowFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $csvFile = file(__DIR__.'./../../database/pub_user.csv');

        $borrowArray = [];
        foreach ($csvFile as $line) {
            $borrowArray[] = str_getcsv($line);
        }
        $i = 0;
        foreach ($borrowArray as $data) {
            if ($i > 0) {
                $data =  explode(";", $data[0]);
                $borrow = new Borrow();
                $borrow->setPublication($this->getReference('publication_' . $data[1]));
                $borrow->setUser($this->getReference('user_' . $data[2]));
                $borrow->setReservationDate(new DateTime('1970-01-01 00:00:01'));
                
                $dateTmp = str_replace('/', '-', $data[3]);
                $dateTmp = date('Y-m-d', strtotime($dateTmp));
                $dateBorrow = new DateTime($dateTmp);
                $borrow->setBorrowedDate($dateBorrow);

                $borrow->setLimitDate(new DateTime('1970-01-01 00:00:01'));
                $borrow->setComment('Emprunt No ' . $i);
                $this->addReference('borrow_' . $data[0], $borrow);
                $manager->persist($borrow);
            }
            $i++;
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            PublicationFixtures::class,
            UserFixtures::class
        ];
    }
}
