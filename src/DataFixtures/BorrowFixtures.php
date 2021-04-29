<?php

namespace App\DataFixtures;

use App\Entity\Borrow;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class BorrowFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $borrow = new Borrow();
        $borrow->setReservationDate(new DateTime('2021-09-01 09:00:00'));
        $borrow->setBorrowedDate(new DateTime('2021-09-05 10:30:00'));
        $borrow->setLimitDate(new DateTime('2021-09-25 15:45:00'));
        $borrow->setComment('Emprunt de test ');
        $borrow->setUser(null);
        $borrow->setPublication(null);

        $manager->persist($borrow);
        $manager->flush();

    }
}