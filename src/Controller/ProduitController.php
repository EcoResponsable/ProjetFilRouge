<?php

namespace App\Controller;

use App\Repository\VendeurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends AbstractController
{
    /**
     * @Route("/vendeur{id}/produit", name="produitsVendeur")
     */
    public function index(VendeurRepository $rep,$id): Response
    {

        $vendeur = $rep->find($id);
        $produits = $vendeur ->getProduits();

        return $this->render('produit/produitsVendeur.html.twig', [
            'produits' => $produits,
            'vendeur'=>$vendeur
        ]);
    }

    
}
