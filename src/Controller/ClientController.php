<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    /**
     * @Route("/client", name="client")
     */
    public function index(): Response
    {
<<<<<<< HEAD
=======
        
>>>>>>> 948187e5ee138874f4bd152d662a6da498ae2063
        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }
}
