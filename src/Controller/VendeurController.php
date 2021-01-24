<?php

namespace App\Controller;

use App\Repository\VendeurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VendeurController extends AbstractController
{
    /**
     * @Route("/allVendeurs", name="vendeur")
     */
    public function index( VendeurRepository $rep): Response
    {
        $vendeurs = $rep->findAll();
        dump($vendeurs);

        return $this->render('vendeur/index.html.twig', [
            'vendeurs'=>$vendeurs,
        ]);
    }
}
