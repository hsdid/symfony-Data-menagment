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
}


