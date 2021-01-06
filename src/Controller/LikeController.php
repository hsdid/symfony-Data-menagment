<?php

namespace App\Controller;

use App\Entity\LikeProduct;
use App\Entity\Product;
use App\Repository\LikeProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;


class LikeController extends AbstractController
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

    public function __construct(EntityManagerInterface $entityManager, LikeProductRepository $likeProductRepository, ProductRepository $productRepository){
       
        $this->entityManager         = $entityManager;
        $this->productRepository     = $productRepository;
        $this->likeProductRepository = $likeProductRepository;
    }
   


    /**
     * @Route("/like/{id}", name="toggleLike")
     * 
     */
    public function toggleLike(int $id){

       
        $user = $this->getUser();
        $user_id = $user->getId();

        $productLike = $this->likeProductRepository->findByUserIdAndProductId($user_id, $id);


        if (!$productLike) {

            $product = $this->productRepository->find($id);

            

            $likeProduct = new LikeProduct();
            $likeProduct->setUser($this->getUser());
            $likeProduct->setProduct($product);

           

            $this->entityManager->persist($likeProduct);
            $this->entityManager->flush();

            return $this->redirectToRoute('home');
        }

            $this->entityManager->remove($productLike);
            $this->entityManager->flush();

        return $this->redirectToRoute('home');
    }
}
