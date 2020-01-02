<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    private $passwordEncoder;
    
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $roleAdmin = new Role();
        $roleAdmin->setCode('ROLE_ADMIN');
        $roleAdmin->setName('Admin');

        $roleUser = new Role();
        $roleUser->setCode('ROLE_USER');
        $roleUser->setName('Utilisateur');

        $userAdmin = new User();
        $userAdmin->setEmail('alexistoanen@gmail.com');
        $userAdmin->setUsername('alexis');
        $userAdmin->setRole($roleAdmin);
        $userAdmin->setPassword($this->passwordEncoder->encodePassword($userAdmin, 'alexisadmin'));

        $manager->persist($roleUser);
        $manager->persist($roleAdmin);
        $manager->persist($userAdmin);

        $manager->flush();
    }
}
