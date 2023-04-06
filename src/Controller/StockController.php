<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StockController extends AbstractController
{
    #[Route('/', name: 'app_stock')]
    public function index(): Response
    {
        return $this->render('stock/index.html.twig', [
            'controller_name' => 'StockController',
        ]);
    }

    #[Route('/product', name: 'create_product')]
    public function ajouter(ManagerRegistry  $Doctrine, Request $request): Response
    {
        $entityManager = $Doctrine->getManager();
        $product=new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form -> handleRequest($request);
        if($form -> isSubmitted()){

            $manager = $Doctrine->getManager();
            $manager-> persist($product);
            $manager-> flush();

            return $this->redirectToRoute('create_product');
        }

        return $this->render('product/ajouter.html.twig', ['form' => $form->createView()]);
    }


    #[Route('/productshow/', name: 'product_show')]
    public function show(ManagerRegistry  $Doctrine): Response
    {
        $repository = $Doctrine->getRepository(Product::class);
        $product =  $repository ->findAll();



        //return new Response('Check out this great product: '.$product->getName());

        // or render a template
        // in the template, print things with {{ product.name }}
         return $this->render('product/show.html.twig', ['product' => $product]);
    }

}
