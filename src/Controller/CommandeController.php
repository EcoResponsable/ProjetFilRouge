<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommandeController extends AbstractController
{
    /**
     * @Route("/commande", name="commande")
     */
    public function index(): Response
    {
        $user = $this->getUser();
        $adresses = $user->getAdresses();
       
        return $this->render('commande/index.html.twig', [
            'adresses' =>$adresses,
        ]);
    }
}
