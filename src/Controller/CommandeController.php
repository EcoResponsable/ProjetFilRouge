<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\ProduitCommande;
use App\Repository\CommandeRepository;
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
    public function index(SessionInterface $session, ProduitRepository $rep,EntityManagerInterface $em): Response
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
                $prixTotal += ($p['produit']->getPrixUnitaireHT() + ($p['produit']->getPrixUnitaireHT() * $p['produit']->getTVA())) * $p['quantite'];
            }
       
        return $this->render('commande/index.html.twig', [
            'adresses' =>$adresses,
            'panier' => $panier,
            'prixTotal' => $prixTotal,
            'adresses' => $adresses
        ]);
    }

    /**
     * @Route("/commandeValidate/", name="commandeValidate")
     */
    public function commandeValidate(SessionInterface $session, ProduitRepository $rep,EntityManagerInterface $em)
    {

        $user = $this->getUser();
        $panier = $session->get('panier');
        $prixTotal = 0;
        
        $commande = new Commande();
        $commande
        ->setClient($user)
        ->setIsPayed(false)
        ->setReference(date('dmY').'-'.uniqid());

        foreach($panier as $id => $quantite){
            $produitCommande = new ProduitCommande();
            $produitCommande
            ->setQuantite($quantite)
            ->setProduit($rep->find($id))
            ->setCommande($commande);
            $em->persist($produitCommande);

            $prod = $rep->find($id);
            $prix = ($prod->getPrixUnitaireHT() + ($prod->getPrixUnitaireHT() * $prod->getTVA())) * $quantite;
            $prixTotal += $prix;
        }

        $em->persist($commande);
        $em->flush();
        $session->set('panier', []);


        return $this->render('commande/commandeValidate.html.twig',[
            'reference' => $commande->getReference(),
            'commande' => $commande,
            'total' => $prixTotal
            ]);
    }

    /**
     * @Route("/commandeSucces/{reference}", name="commandeSucces")
     */
    public function Succes($reference, CommandeRepository $repCommande,ProduitRepository $repProduit, EntityManagerInterface $em): Response
    {

        // permet de retirer les produits achetés des stocks
        $commande = $repCommande->findOneBy(['reference' => $reference]);
        $commande->setIsPayed(true);
        $em->persist($commande);
        $produitCommandes = $commande->getProduitCommandes();

        foreach($produitCommandes as $produitCommande){

            $quantite = $produitCommande->getQuantite();
            $produit = $produitCommande->getProduit();
            $produit->setStock($produit->getStock()-$quantite);
            $em->persist($produit);

        };

        $em->flush();

       
        return $this->render('commande/commandeSucces.html.twig', [
            
        ]);
    }
}
