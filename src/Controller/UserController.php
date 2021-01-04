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
}
