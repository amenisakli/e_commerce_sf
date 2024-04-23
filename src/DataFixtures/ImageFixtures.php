<?php

namespace App\DataFixtures;
use App\Entity\Images;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class ImageFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        for($img= 1;$img<=10; $img++ ){
            $image=new Images();
            $image->setName($faker->image(null,640,480));
            $randomProductId = rand(1, 10); // Generate a random product ID
            $product = $this->getReference('prod-'.$randomProductId);
            $image->setProducts($product);
            
            $manager->persist($image);
        }
        $manager->flush();
    }
    public function getDependencies():array{
        return 
       [ 
        ProductsFixtures::class
       ];
    }
}
