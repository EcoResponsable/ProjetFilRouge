<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Entity\Commande;
use App\Entity\ProduitCommande;
use App\Form\LivreurformType;
use App\Repository\AdresseRepository;
use App\Repository\LivreurRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;


class CommandeController extends AbstractController
{
    /**
     * @Route("/clientcommande{adresseLivraison?}", name="commande")
     */
    public function index(SessionInterface $session, ProduitRepository $rep, $adresseLivraison, LivreurRepository $repLivreur,  Request $req): Response
    {

        $user = $this->getUser();

        $adresses = $user->getAdresses();
        $livreur = $repLivreur->findAll();
   
        
        $produits = $session->get('panier', []);
            $prixTotal = 0;
            $panier = [];

            foreach($produits as $id => $quantite){
                $panier[] = [
                    'produit' => $rep->find($id),
                    'quantite' => $quantite
                ];
            }

            $livreurForm = $this->createForm(LivreurformType::class, $livreur);
            $livreurForm->handleRequest($req);
            
            if($livreurForm->isSubmitted() && $livreurForm->isSubmitted()){
                

                $livreur = $session->get('livreur', []);
                $prixLivreur = $livreurForm->getData(); 
                $session->set('livreur',$prixLivreur['nom']);
                
             
                return $this->redirectToRoute('commandeValidate');
            }
           

            foreach($panier as $p){
                $prixTotal += ($p['produit']->getPrixUnitaireHT() + ($p['produit']->getPrixUnitaireHT() * $p['produit']->getTVA())) * $p['quantite'];
            }
       
        return $this->render('commande/index.html.twig', [
            'adresses' =>$adresses,
            'panier' => $panier,
            'prixTotal' => $prixTotal,
            'adresseLivraison'=>$adresseLivraison,
            'livreurs'=>$livreur,
            'livreurForm'=>$livreurForm->createView()
            
        ]);
    }

    /**
     * @Route("/commandeValidate/", name="commandeValidate")
     */
    public function commandeValidate(SessionInterface $session, ProduitRepository $rep, EntityManagerInterface $em)
    {
        $user = $this->getUser();
        $panier = $session->get('panier');
        $livreur = $session->get('livreur');
        
        $prixTotal = 0;


        $prixLivraison = $livreur->getTarif();
        

       
        $commande = new Commande();
        $commande->setClient($user)
        ->setReference(date('dmY').'-'.uniqid());

        foreach($panier as $id => $quantite){
            $produitCommande = new ProduitCommande();
            $produitCommande
            ->setQuantite($quantite)
            ->setProduit($rep->find($id))
            ->setCommande($commande);
            $em->persist($produitCommande);

            $prod = $rep->find($id);
            $prix = $prod->getPrixUnitaireHT() + ($prod->getPrixUnitaireHT() * $prod->getTVA());
            $prixTotal += $prix + $prixLivraison;
        }

        $em->persist($commande);
        $em->flush();
        // $session->set('panier', []);  REINITIALISATION DU PANIER
        
       return $this->render('commande/commandeValidate.html.twig',[
            'reference' => $commande->getReference(),
            'commande' => $commande,
            'total' => $prixTotal
       ]);
    }

}
