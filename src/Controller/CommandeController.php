<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\ProduitCommande;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CommandeController extends AbstractController
{
    /**
     * @Route("/clientcommande", name="commande")
     */
    public function index(SessionInterface $session, ProduitRepository $rep): Response
    {
        $user = $this->getUser();
        $adresses = $user->getAdresses();
        $produits = $session->get('panier', []);
            $prixTotal = 0;
            $panier = [];

            foreach($produits as $id => $quantite){
                $panier[] = [
                    'produit' => $rep->find($id),
                    'quantite' => $quantite
                ];
            }

            foreach($panier as $p){
                $prixTotal += $p['produit']->getPrixUnitaireHT() * $p['quantite'];
            }
       
        return $this->render('commande/index.html.twig', [
            'adresses' =>$adresses,
            'panier' => $panier,
            'prixTotal' => $prixTotal
        ]);
    }

    /**
     * @Route("/commandeValidate/", name="commandeValidate")
     */
    public function commandeValidate(SessionInterface $session, ProduitRepository $rep,EntityManagerInterface $em)
    {

        $user = $this->getUser();
        $panier = $session->get('panier');
        
        $commande = new Commande();
        $commande->setClient($user)
        ->setReference(date('DmY').'-'.uniqid());

        foreach($panier as $id => $quantite){
            $produitCommande = new ProduitCommande();
            $produitCommande
            ->setQuantite($quantite)
            ->setProduit($rep->find($id))
            ->setCommande($commande);
            $em->persist($produitCommande);
        }

        $em->persist($commande);
        $em->flush();
        $session->set('panier', []);
        
       return $this->render('commande/commandeValidate.html.twig',[
           'reference'=>$commande->getReference()
       ]);
    }
}
