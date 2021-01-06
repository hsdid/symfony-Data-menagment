<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class UserController extends AbstractController
{


       /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var UserRepository
     */

    private $userRepository;

    /**
     * @var ProductRepository
     */

    private $productRepository;

    
    public function __construct(EntityManagerInterface $entityManager, UserRepository $userRepository, ProductRepository $productRepository){
       
        $this->entityManager      = $entityManager;
        $this->userRepository     = $userRepository;
        $this->productRepository  = $productRepository;
    }



    /**
     * @Route("/user", name="users_list")
     */
    public function index(): Response
    {   

        $users = $this->userRepository->findAll();

       

        return $this->render('user/index.html.twig', array(
            'users' => $users
        ));
    }


    /** 
     * @Route("/user/sortByNumOfPRoducts/{sort}", name="userProductsSortByProductsNumber")
     * Method({"GET"})
     */
    public function sortByProductsDESC(string $sort) {

        
        $users = $this->userRepository->userByNumOfProducts($sort);
        
        
        return $this->render('user/index.html.twig', array(
            'users' => $users,
        ));

    }


    /** 
     * @Route("/user/sortByLikes/{sort}", name="userSortByLikesNumber")
     * Method({"GET"})
     */
    public function sortByLikesDESC (string $sort) {

        
        $users = $this->userRepository->userByNumOfLikes($sort);
        
        
        return $this->render('user/index.html.twig', array(
            'users' => $users,
        ));

    }



    /** 
     * @Route("/user/{id}/products", name="userProductById")
     * Method({"GET"})
     */
    public function userProductById (int $id) {

        
        $user = $this->userRepository->find($id);

        $products = $user->getProducts();
        
        
        return $this->render('user/products.html.twig', array(

            'products' => $products,
            'user'     => $user

        ));

    }

     /** 
     * @Route("/user/{id}/products/sortByLikes/{sort}", name="userProductsSortLikes")
     * Method({"GET"})
     */
    public function sortUserProductsByLike (int $id, string $sort) {

        $user = $this->userRepository->find($id);

        $products = $this->productRepository->findByUserIdNumberOfProductLikes($id, $sort);
        
        
        return $this->render('user/products.html.twig', array(
            'user'     => $user,
            'products' => $products
        ));

    }

    /** 
     * @Route("/user/{id}/products/sortByPublicTime/{sort}", name="userProductsSortPublicTime")
     * Method({"GET"})
     */
    public function sortUserProductsByPublicTime (int $id, string $sort) {


        $user = $this->userRepository->find($id);

        $products = $this->productRepository->findBy(
            ['user'        => $user],
            ['public_date' => $sort]
        );
        
        
        return $this->render('user/products.html.twig', array(
            'user'     => $user,
            'products' => $products
        ));

    }



    

}
