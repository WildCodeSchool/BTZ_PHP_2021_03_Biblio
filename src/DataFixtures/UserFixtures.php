<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;
    private $slugify;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, Slugify $slugify)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->slugify = $slugify;
    }

    public function load(ObjectManager $manager)
    {
        $csvFile = file(__DIR__.'./../../database/user.csv');

        $userArray = [];
        foreach ($csvFile as $line) {
            $userArray[] = str_getcsv($line);
        }
        $i = 0;
        $faker = Faker\Factory::create('us_US');
        foreach ($userArray as $data) {
            if ($i > 0) {
                $data =  explode(";", $data[0]);
                $user = new User();
                $user->setEmail($faker->email);
                if ($data[0] > 400) {
                    $user->setRoles(['ROLE_OPERATOR']);
                    $user->setPassword($this->passwordEncoder->encodePassword($user, 'operator'));
                    $user->setNewsletter(false);
                    $user->setSlug($this->slugify->generate('operator-slug'));
                } else {
                    $user->setRoles(['ROLE_PUBLIC']);
                    $user->setPassword($this->passwordEncoder->encodePassword($user, 'public'));
                    $user->setNewsletter(true);
                    $user->setSlug($this->slugify->generate('public-slug'));
                }
                $user->setFullName($data[1]);
                $user->setPhone('0600000000');
                $user->setAddress($faker->address);

                $this->addReference('user_' . $data[0], $user);
                $manager->persist($user);
            }
            $i++;
        }

        $manager->flush();
        /**
         * Admin.
         */
        $faker = Faker\Factory::create('us_US');
        $admin = new User();
        $admin->setEmail('admin@yopmail.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordEncoder->encodePassword($admin, 'admin'));
        $admin->setFirstname('ADMIN FIRSTNAME');
        $admin->setLastname('ADMIN LASTNAME');
        $admin->setPhone('0600000000');
        $admin->setAddress('3 rue des Admins 64200 Bayonne');
        $admin->setNewsletter(false);
        $admin->setSlug($this->slugify->generate('admin-slug'));
        $manager->persist($admin);
        $manager->flush();

        /**
         * Opérateur d'édition.
         */
        $operator = new User();
        $operator->setEmail('operator@yopmail.com');
        $operator->setRoles(['ROLE_OPERATOR']);
        $operator->setPassword($this->passwordEncoder->encodePassword($operator, 'operator'));
        $operator->setFirstname($faker->firstName);
        $operator->setLastname($faker->lastName);
        $operator->setPhone('0600000000');
        $operator->setAddress('3 rue des Operators 64200 Bayonne');
        $operator->setNewsletter(false);
        $operator->setSlug($this->slugify->generate('operator-slug'));
        $manager->persist($operator);
        $manager->flush();

        /**
         * Membres équipe Audap.
         */
        $audap_member = new User();
        $audap_member->setEmail('member@yopmail.com');
        $audap_member->setRoles(['ROLE_AUDAP_MEMBER']);
        $audap_member->setPassword($this->passwordEncoder->encodePassword($audap_member, 'member'));
        $audap_member->setFirstname($faker->firstName);
        $audap_member->setLastname($faker->lastName);
        $audap_member->setSlug($this->slugify->generate('equipe-audap-slug'));
        $audap_member->setPhone('0600000000');
        $audap_member->setAddress('3 rue des Members 64200 Bayonne');
        $audap_member->setNewsletter(true);
        $audap_member->setSlug($this->slugify->generate('operator-slug'));
        $manager->persist($audap_member);
        $manager->flush();

        /**
         * Partenaire Audap.
         */
        $audap_partner = new User();
        $audap_partner->setEmail('partner@yopmail.com');
        $audap_partner->setRoles(['ROLE_AUDAP_PARTNER']);
        $audap_partner->setPassword($this->passwordEncoder->encodePassword($audap_partner, 'partner'));
        $audap_partner->setFirstname($faker->firstName);
        $audap_partner->setLastname($faker->lastName);
        $audap_partner->setPhone('0600000000');
        $audap_partner->setAddress('3 rue des Partners 64200 Bayonne');
        $audap_partner->setNewsletter(false);
        $audap_partner->setSlug($this->slugify->generate('partner-audap-slug'));
        $manager->persist($audap_partner);
        $manager->flush();

        /**
         * Public.
         */
        $public = new User();
        $public->setEmail('public@yopmail.com');
        $public->setRoles(['ROLE_PUBLIC']);
        $public->setPassword($this->passwordEncoder->encodePassword($public, 'public'));
        $public->setFirstname('public_firstname');
        $public->setLastname('public_lastname');
        $public->setSlug($this->slugify->generate('public-slug'));
        $public->setPhone('0600000000');
        $public->setAddress('3 rue des Publics 64200 Bayonne');
        $public->setNewsletter(true);
        $manager->persist($public);
        $manager->flush();
    }
}
