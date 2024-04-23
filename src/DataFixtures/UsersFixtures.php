<?php

namespace App\DataFixtures;
use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Faker;

class UsersFixtures extends Fixture
{  
    private UserPasswordHasherInterface  $passwordEncoder;
    private SluggerInterface $slugger;

    public function __construct( UserPasswordHasherInterface $passwordEncoder,SluggerInterface $slugger){
        $this->passwordEncoder=$passwordEncoder;
        $this->slugger = $slugger;

    }
    public function load(ObjectManager $manager): void
    {
        $admin = new Users();
        $admin -> setEmail('admin@demo.fr');
        $admin -> setLastname('admin');
        $admin -> setFirstname('admin');
        $admin -> setAdresse('12 rue de port');
        $admin -> setZipcode('12345');
        $admin -> setCity('Paris');
        $admin -> setPassword(
            $this -> passwordEncoder -> hashPassword($admin,'admin')
        );
        $admin -> setRoles(['Role_Admin']);

        $manager->persist($admin);

        $faker = Faker\Factory::create('fr_FR');

        for($usr= 1;$usr<=5; $usr++ ){
            $user = new Users();
            $user -> setEmail($faker -> email);
            $user -> setLastname($faker -> lastName);
            $user -> setFirstname($faker -> firstName);
            $user -> setAdresse($faker -> streetAddress);
            $user -> setZipcode($faker -> postcode);
            $user -> setCity($faker -> city);
            $user -> setPassword(
                $this -> passwordEncoder -> hashPassword($user,'secret')
            );    
            $manager->persist($user);
        }
        $manager->flush();
    }
}
