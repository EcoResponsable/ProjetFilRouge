<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestMatcherInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart")
     */

    public function index(SessionInterface $session, ProduitRepository $prodRep): Response
    {

        $panier = $session->get('panier',[]); //on met dans $panier ce qui est present dans $session
        
        //On cree un nouveau tableau dans le tableau de session pour stocker les infos du produit

        $panierWithData = []; // on initialise un tableau vide qu'on va remplir de produits

        foreach($panier as $id => $quantite){ //On rempli le tableau panier avec le produit et la qt
            $panierWithData[] = [
                'produit' => $prodRep->find($id),
                'quantite'=>$quantite
            ];
        }

       

        $total =0; // on calcule le total
        foreach($panierWithData as $item){ //pour tous les produuits du tableau de produit
            $total += $item['produit']->getPrixUnitaireHT()*$item['quantite']; // tu m'ajoutes les articles x les qt au total 
             
        }
   

        return $this->render('cart/index.html.twig', [

            'items'=> $panierWithData,
            'total'=>$total

        ]);
    }


    /**
     * @Route("/cart/add{id}", name="cart_add")
     */

    public function add($id, SessionInterface $session): Response //sessionInterface initialise une nouvelle session Infos =>symfony console debug:autowiring session
    {
        $panier = $session->get('panier',[]);//recupere un panier vide dans lequel on stock un tableau d'articles

        if(!empty($panier[$id])){  //Si le panier est deja rempli, on incrémente l'article pour augmenter la qt
            $panier[$id]++;

        }else{
          $panier[$id] = 1;  //Si le panier est vide, on met un article
        }
        
        $session->set('panier', $panier);

        
        return $this->redirectToRoute('cart');


    }


      /**
     * @Route("/cart/delete{id}", name="cart_delete")
     */
    public function delete($id, SessionInterface $session): Response 
    {
    
        $panier = $session->get('panier',[]); // On récupere la session avec le panier rempli et on le fout dans $panier
        
        if(!empty($panier[$id])){   //si le panier est rempli avec l'ID selectionné
            unset($panier[$id]);    // ça dégage
        }

        $session->set('panier', $panier); //on modifie la session avec le nouveau panier tout beau tout propre
        
        return $this->redirectToRoute('cart');


    }
}
