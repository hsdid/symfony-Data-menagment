<?php

namespace App\Controller;

use App\Entity\LikeProduct;
use App\Entity\User;
use App\Repository\LikeProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Expr\Cast\String_;

class HomeController extends AbstractController
{

     /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @var LikeProductRepository
     */
    private $likeProductRepository;


    public function __construct(EntityManagerInterface $entityManager,LikeProductRepository $likeProductRepository, ProductRepository $productRepository){
       
        $this->entityManager         = $entityManager;
        $this->productRepository     = $productRepository;
        $this->likeProductRepository = $likeProductRepository;


    }

    
    /**
     * @Route("/home", name="home")
     */
    public function index(): Response
    {   

        $products = $this->productRepository->findAll();
        $user = $this->getUser();
        $userLikes = $user->getLikes();

        return $this->render('home/index.html.twig', array(
            'products' => $products,
            'userLikes' => $userLikes
        ));
    }


     /** 
     * @Route("/home/sortByLike/{sort}", name="homesortByLike")
     * Method({"GET"})
     */
    public function sortByLike (string $sort) {

        $user = $this->getUser();
        $userLikes = $user->getLikes();

        $products = $this->productRepository->findByLikes($sort);

        return $this->render('home/index.html.twig', array(
            'products' => $products,
            'userLikes' => $userLikes
        ));

    }


     /** 
     * @Route("/home/sortByDate/{sort}", name="homesortByDate")
     * Method({"GET"})
     */
    public function sortByDate (string $sort) {

        $user = $this->getUser();
        $userLikes = $user->getLikes();

        $products = $this->productRepository->findBy([],[
            'public_date' => $sort
        ]);

        return $this->render('home/index.html.twig', array(
            'products' => $products,
            'userLikes' => $userLikes
        ));

    }

   
    /** 
     * @Route("/home/allLiked", name="likedProduct")
     * Method({"GET"})
     */
    public function allLikedProduct () {


        $user      = $this->getUser();
        $products  = $user->getLikedProduct();
        $userLikes = $user->getLikes();
        
        
        
        return $this->render('home/index.html.twig', array(
            'products' => $products,
            'userLikes' => $userLikes
        ));

    }

}


