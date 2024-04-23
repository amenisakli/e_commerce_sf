<?php
namespace App\Controller;

use App\Entity\Products;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface; // Add this import

#[Route('/products', name: 'products_')]
class ProductsController extends AbstractController
{
    private $entityManager;

    // Inject EntityManagerInterface
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('products/index.html.twig');
    }

    #[Route('/{slug}', name: 'details')]
    public function details(string $slug): Response
    {
        $product = $this->entityManager->getRepository(Products::class)->findOneBy(['slug' => $slug]);

        if (!$product) {
            throw $this->createNotFoundException('Product not found');
        }
        return $this->render('products/details.html.twig',compact('product'));
    }
}

