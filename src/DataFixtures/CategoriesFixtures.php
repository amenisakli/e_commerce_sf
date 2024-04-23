<?php

namespace App\DataFixtures;
use App\Entity\Categories;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoriesFixtures extends Fixture
{ 
    private $counter = 1;
    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }
    public function load(ObjectManager $manager): void
    {
        $parent = $this -> createCategiry('Informatique',null,$manager);

       $this ->createCategiry ('Ordinateur Portable',$parent,$manager);
       $this ->createCategiry ('Ecran',$parent,$manager);
       $this ->createCategiry ('Souris',$parent,$manager);

       $parent = $this -> createCategiry('Mode',null,$manager);

       $this ->createCategiry ('Homme',$parent,$manager);
       $this ->createCategiry ('Femme',$parent,$manager);
       $this ->createCategiry ('Enfant',$parent,$manager);


        $manager->flush();
    }
    public function createCategiry(string $name , Categories $parent = null, ObjectManager $manager) {
        $category = new Categories();
        $category->setName($name);
        $category->setSlug($this ->slugger ->slug($category -> getName())->lower());
        $category->setParent($parent);
        $manager->persist($category);

        $this ->addReference('cat-'.$this->counter,$category);
        $this->counter++;

        return $category;
    }
}
