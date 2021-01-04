<?php

namespace App\Controller;

use App\Repository\UserRepository;
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

    
    public function __construct(EntityManagerInterface $entityManager, UserRepository $userRepository){
       
        $this->entityManager      = $entityManager;
        $this->userRepository     = $userRepository;
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
     * @Route("/user/sortByProducts/DESC", name="userSortByProductsDESC")
     * Method({"GET"})
     */
    public function sortByProductsDESC () {

        
        $users = $this->userRepository->userDescProducts();
        
        
        return $this->render('user/index.html.twig', array(
            'users' => $users,
        ));

    }


    /** 
     * @Route("/user/sortByProducts/ASC", name="userSortByProductsASC")
     * Method({"GET"})
     */
    public function sortByProductsASC () {

        
        $users = $this->userRepository->userASCProducts();
        
        
        return $this->render('user/index.html.twig', array(
            'users' => $users,
        ));

    }

    /** 
     * @Route("/user/sortByLikes/DESC", name="userSortByLikesDESC")
     * Method({"GET"})
     */
    public function sortByLikesDESC () {

        
        $users = $this->userRepository->userDescLikes();
        
        
        return $this->render('user/index.html.twig', array(
            'users' => $users,
        ));

    }


    /** 
     * @Route("/user/sortByLikes/ASC", name="userSortByLikesASC")
     * Method({"GET"})
     */
    public function sortByLikesASC () {

        
        $users = $this->userRepository->userASCLikes();
        
        
        return $this->render('user/index.html.twig', array(
            'users' => $users,
        ));

    }

    

}
