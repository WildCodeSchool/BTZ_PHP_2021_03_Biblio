<?php

namespace App\DataFixtures;

use App\Entity\Borrow;
use App\Entity\Publication;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BorrowFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $borrow = new Borrow();
        $user = new User();
        $publication = new Publication();
        $borrow->setReservationDate(new DateTime('2021-09-01 09:00:00'));
        $borrow->setBorrowedDate(new DateTime('2021-09-05 10:30:00'));
        $borrow->setLimitDate(new DateTime('2021-09-25 15:45:00'));
        $borrow->setComment('Emprunt de test');
        $borrow->setUser($user->getId(1));
        $borrow->setPublication($publication->getId(1));
        
        $manager->persist($borrow);
        $manager->flush();

    }
}
