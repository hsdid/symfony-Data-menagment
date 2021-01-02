<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
//use Symfony\Component\Security\Core\Security;
class ProductController extends AbstractController
{
   /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var ProductRepository
     */

    private $productRepository;

    public function __construct(EntityManagerInterface $entityManager, ProductRepository $productRepository){
       
        $this->entityManager      = $entityManager;
        $this->productRepository  = $productRepository;
    }

    /**
     * @Route("/product", name="product")
     
     */
    public function index(): Response 
    {
        $products = $this->productRepository->findAll();

        return $this->render('product/index.html.twig', array(
            'products' => $products
        ));
    }




    /**
     * @Route("/product/new", name="addProduct")
     * Method({"GET","POST"})
     */

    public function addProduct(Request $request) {
        
        if ($request->isMethod('POST')) {

            $name = $request->get('name');
            $info = $request->get('info');
            $user = $this->getUser();
            
            if ($name && $info) {

                $product = new Product();

                $product->setName($name);
                $product->setInfo($info);
                $product->setUser($user);
            
            
                $this->entityManager->persist($product);
                $this->entityManager->flush();

                return $this->redirectToRoute('product');
                
            }
        }

        return $this->render('product/new.html.twig', array(
        ));

    }

    /** 
     * @Route("/product/{id}", name="delProduct")
     * Method({"DELETE"})
     */
    public function deleteProduct(int $id)
    {
       
        $product = $this->productRepository->find($id);
        
        

        $this->entityManager->remove($product);
        $this->entityManager->flush();

        return $this->redirectToRoute('product');
    }
    


}
