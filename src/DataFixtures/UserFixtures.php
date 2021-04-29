<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;
    
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        /**
         * Admin
         */
        $admin = new User();
        $admin->setEmail('admin@yopmail.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordEncoder->encodePassword($admin,'admin'));
        $admin->setFirstname('admin_firstname');
        $admin->setLastname('admin_lastname');
        $admin->setPhone('0600000000');
        $admin->setAddress('3 rue des Admins 64200 Bayonne');
        $admin->setNewsletter(false);
        $manager->persist($admin);
        $manager->flush();

        /**
         * Opérateur d'édition
         */
        $operator = new User();
        $operator->setEmail('operator@yopmail.com');
        $operator->setRoles(['ROLE_OPERATOR']);
        $operator->setPassword($this->passwordEncoder->encodePassword($operator,'operator'));
        $operator->setFirstname('operator_firstname');
        $operator->setLastname('operator_lastname');
        $operator->setPhone('0600000000');
        $operator->setAddress('3 rue des Operators 64200 Bayonne');
        $operator->setNewsletter(false);
        $manager->persist($operator);
        $manager->flush();

        /**
         * Membres équipe Audap
         */
        $audap_member = new User();
        $audap_member->setEmail('member@yopmail.com');
        $audap_member->setRoles(['ROLE_AUDAP_MEMBER']);
        $audap_member->setPassword($this->passwordEncoder->encodePassword($audap_member,'member'));
        $audap_member->setFirstname('member_firstname');
        $audap_member->setLastname('member_lastname');
        $audap_member->setPhone('0600000000');
        $audap_member->setAddress('3 rue des Members 64200 Bayonne');
        $audap_member->setNewsletter(true);
        $manager->persist($audap_member);
        $manager->flush();

        /**
         * Membres équipe Audap
         */
        $public = new User();
        $public->setEmail('public@yopmail.com');
        $public->setRoles(['ROLE_PUBLIC']);
        $public->setPassword($this->passwordEncoder->encodePassword($public,'public'));
        $public->setFirstname('public_firstname');
        $public->setLastname('public_lastname');
        $public->setPhone('0600000000');
        $public->setAddress('3 rue des Publics 64200 Bayonne');
        $public->setNewsletter(true);
        $manager->persist($public);
        $manager->flush();

        /**
         * Partenaire Audap
         */
        $audap_partner = new User();
        $audap_partner->setEmail('partner@yopmail.com');
        $audap_partner->setRoles(['ROLE_AUDAP_PARTNER']);
        $audap_partner->setPassword($this->passwordEncoder->encodePassword($audap_partner,'partner'));
        $audap_partner->setFirstname('partner_firstname');
        $audap_partner->setLastname('partner_lastname');
        $audap_partner->setPhone('0600000000');
        $audap_partner->setAddress('3 rue des Partners 64200 Bayonne');
        $audap_partner->setNewsletter(false);
        $manager->persist($audap_partner);
        $manager->flush();
    }
}