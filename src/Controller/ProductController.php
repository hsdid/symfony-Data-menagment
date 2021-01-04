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
     * @Route("/product", name="user_product_list")
     
     */
    public function index(): Response 
    {   

        $userProduct = $this->productRepository->findBy(['user' => $this->getUser()]);
        
        //dd($userProduct[0]->getLikes()[0] );
        return $this->render('product/index.html.twig', array(
            'products' => $userProduct
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
                $product->setPublicDate(new \DateTime());
                
                
                $this->entityManager->persist($product);
                $this->entityManager->flush();
                
                
                return $this->redirectToRoute('user_product_list');
                
            }
        }

        return $this->render('product/new.html.twig', array(
        ));

    }

    /** 
     * @Route("/product/sortByDate/ASC", name="sortByDateASC")
     * Method({"GET","POST"})
     */
    public function sortByDateASC () {

        $userProduct = $this->productRepository->findBy(
            ['user' => $this->getUser()],
            ['public_date' => 'ASC']
            
        );

        return $this->render('product/index.html.twig', array(
            'products' => $userProduct
        ));

    }

    /** 
     * @Route("/product/sortByDate/DESC", name="sortByDateDESC")
     * Method({"GET","POST"})
     */
    public function sortByDateDESC () {

        $userProduct = $this->productRepository->findBy(
            ['user' => $this->getUser()],
            ['public_date' => 'DESC']
            
        );

        return $this->render('product/index.html.twig', array(
            'products' => $userProduct
        ));

    }

     /** 
     * @Route("/product/sortByLike/ASC", name="productsortByLikeASC")
     * Method({"GET","POST"})
     */
    public function sortByLikeASC () {

        $user = $this->getUser();
        

        $products = $this->productRepository->findByUserProductASCLikes($user->getId());

        return $this->render('product/index.html.twig', array(
            'products' => $products,
            
        ));

    }

    /** 
     * @Route("/product/sortByLike/DESC", name="productsortByLikeDESC")
     * Method({"GET","POST"})
     */
    public function sortByLikeDESC () {

        $user = $this->getUser();
        
        $products = $this->productRepository->findByUserProductDescLikes($user->getId());
        
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
        
       
        if ($request->isMethod('POST')) {

            $name = $request->get('name');
            $info = $request->get('info');

            $product->setName($name);
            $product->setInfo($info);

            $this->entityManager->persist($product);
            $this->entityManager->flush();

            return $this->redirectToRoute('user_product_list');
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
        
        

        $this->entityManager->remove($product);
        $this->entityManager->flush();

        return $this->redirectToRoute('user_product_list');
        
    }
    
    


}
