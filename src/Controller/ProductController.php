<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;
use DateTimeInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Security\Voter\AuthorVoter;
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
     * @Route("/product", name="userProductList")
     
     */
    public function index(): Response 
    {   

        $userProduct = $this->productRepository->findBy(['user' => $this->getUser()]);
        
        
        return $this->render('product/index.html.twig', array(
            'products' => $userProduct,
          
        ));
    }


    /**
     * @Route("/product/new", name="addProduct")
     * Method({"GET","POST"})
     */

    public function addProduct(Request $request) {
        

        //$this->denyAccessUnlessGranted('ROLE_USER');


        if ($request->isMethod('POST')) {

            $name = $request->get('name');
            $info = $request->get('info');
            $user = $this->getUser();
            
            if ($name && $info) {
                
               
                $product = new Product();

                $product->setName($name);
                $product->setInfo($info);
                $product->setUser($user);
                
                $product->setPublicDate(new \DateTime());
                
                
                $this->entityManager->persist($product);
                $this->entityManager->flush();
                
                
                return $this->redirectToRoute('userProductList');
                
            }
        }

        return $this->render('product/new.html.twig', array(
        ));

    }

    /** 
     * @Route("/product/sortByDate/{sort}", name="productSortByDate")
     * Method({"GET","POST"})
     */
    public function sortByDate (string $sort) {

        $userProduct = $this->productRepository->findBy(
            ['user' => $this->getUser()],
            ['public_date' => $sort]
            
        );

        return $this->render('product/index.html.twig', array(
            'products' => $userProduct
        ));
        
    }


    /** 
     * @Route("/product/sortByName/{sort}", name="productSortByName")
     * Method({"GET","POST"})
     */
    public function sortByName (string $sort) {

        $userProduct = $this->productRepository->findBy(
            ['user' => $this->getUser()],
            ['name' => $sort]
            
        );

        return $this->render('product/index.html.twig', array(
            'products' => $userProduct
        ));
        
    }

    /** 
     * @Route("/product/sortByInfo/{sort}", name="productSortByInfo")
     * Method({"GET","POST"})
     */
    public function sortByInfo (string $sort) {

        $userProduct = $this->productRepository->findBy(
            ['user' => $this->getUser()],
            ['info' => $sort]
            
        );

        return $this->render('product/index.html.twig', array(
            'products' => $userProduct
        ));
        
    }
    
     /** 
     * @Route("/product/sortByLike/{sort}", name="productSortByLike")
     * Method({"GET","POST"})
     */
    public function sortByLike (string $sort) {

        $user = $this->getUser();
        
       
        $products = $this->productRepository->findByUserIdProductLikes($user->getId(), $sort);

        return $this->render('product/index.html.twig', array(
            'products' => $products,
            
        ));

    }

    


    /** 
     * @Route("/product/edit/{id}", name="editProduct")
     * Method({"GET","POST"})
     */
    public function editProduct(int $id, Request $request)
    {
       
        $product = $this->productRepository->find($id);
        
        
        
        if (!$this->isGranted(AuthorVoter::EDIT, $product)) {
            
            return $this->redirectToRoute('userProductList');
        }
       

        if ($request->isMethod('POST')) {

            $name = $request->get('name');
            $info = $request->get('info');
            $date = $request->get('date');

            $public_date = date_create_from_format('Y-m-d', $date);
            
            $product->setName($name);
            $product->setInfo($info);
            $product->setPublicDate($public_date);
            
            $this->entityManager->persist($product);
            $this->entityManager->flush();

            return $this->redirectToRoute('userProductList');
        }

        return $this->render('product/edit.html.twig', array(
            'product' => $product
            
        ));
        
       
    }


    /** 
     * @Route("/product/{id}", name="delProduct")
     * Method({"DELETE"})
     */
    public function deleteProduct(int $id)
    {
       
        $product = $this->productRepository->find($id);


        if (!$this->isGranted(AuthorVoter::DELETE, $product)) {
            
            return $this->redirectToRoute('userProductList');
        }
        
        $this->entityManager->remove($product);
        $this->entityManager->flush();

        return $this->redirectToRoute('userProductList');
        
    }
    

}
