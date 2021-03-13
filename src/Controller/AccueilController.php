<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use App\Repository\VendeurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(EntityManagerInterface $em, ProduitRepository $repProduit): Response
    {
        $produits = $repProduit->findBest();
        $vendeurs = [];

        $groupeProduits = $repProduit->findBestVendeur();
        
        foreach ($groupeProduits as $p){

            $vendeurs[] = $p->getVendeur();

        }
 
        return $this->render('accueil/index.html.twig', [
            'produits' => $produits,
            'vendeurs' => $vendeurs,

        ]);
    }

   
}
