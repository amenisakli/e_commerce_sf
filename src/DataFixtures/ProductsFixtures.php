<?php

namespace App\DataFixtures;
use App\Entity\Products;
use Symfony\Component\String\Slugger\SluggerInterface;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
class ProductsFixtures extends Fixture
{
    private $counter = 1;

    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger){
        $this->slugger = $slugger;

    }
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        for($prod= 1;$prod<=10; $prod++ ){
            $product = new Products();
            $product -> setName($faker -> text(15));
            $product -> setDescription($faker -> text());
            $product -> setSlug($this -> slugger->slug($product->getName())->lower());
            $product -> setPrice($faker -> numberBetween(900,150000));
            $product -> setStock($faker -> numberBetween(0,10));

            $category = $this -> getReference('cat-'.rand(1,8));
            $product -> setCategories($category);  
            $manager->persist($product);
            $this ->addReference('prod-'.$this->counter,$product);
            $this->counter++;

        }
        $manager->flush();
    }
}
