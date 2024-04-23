<?php
namespace App\Controller;

use App\Entity\Categories;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/categories', name: 'categories_')]
class CategoriesController extends AbstractController
{
    #[Route('/{slug}', name: 'list')]
    public function list(string $slug, EntityManagerInterface $entityManager): Response
    {
      $category = $entityManager->getRepository(Categories::class)->findOneBy(['slug' => $slug]);
    
      if (!$category) {
        throw $this->createNotFoundException('Category not found');
      }
    $products = $category ->getProducts();
      return $this->render('Categories/list.html.twig', compact('category','products'));
    }
    
}

