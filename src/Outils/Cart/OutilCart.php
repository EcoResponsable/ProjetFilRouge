<?php

namespace App\Outils\Cart;

use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class OutilCart{

    protected $session;
    protected $prodRep;


    public function __construct( SessionInterface $session, ProduitRepository $prodRep)
    {
        $this->session = $session;
        $this->prodRep = $prodRep;
          
    }


    public function add(int $id){
        $panier = $this->session->get('panier',[]);//recupere un panier vide dans lequel on stock un tableau d'articles

        if(!empty($panier[$id])){  //Si le panier est deja rempli, on incrémente l'article pour augmenter la qt
            $panier[$id]++;

        }else{
          $panier[$id] = 1;  //Si le panier est vide, on met un article
        }
        
        $this->session->set('panier', $panier);
    }

    public function remove(int $id){


        $panier = $this->session->get('panier',[]); // On récupere la session avec le panier rempli et on le fout dans $panier
        
        if(!empty($panier[$id])){   //si le panier est rempli avec l'ID selectionné
            unset($panier[$id]);    // ça dégage
        }

        $this->session->set('panier', $panier); //on modifie la session avec le nouveau panier tout beau tout propre

        
    }

     public function getFullCart():array
     {

        $panier = $this->session->get('panier',[]);
        //on met dans $panier ce qui est present dans $session
      
        //On cree un nouveau tableau dans le tableau de session pour stocker les infos du produit

        $panierWithData = [];
        // on initialise un tableau vide qu'on va remplir de produits

        foreach($panier as $id => $quantite){ 
            //On rempli le tableau panier avec le produit et la qt
            $panierWithData[] = [

                'produit' => $this->prodRep->find($id),
                'quantite'=>$quantite

            ];
        }
        return $panierWithData;



     }

     public function getTotal() : float{

        $panierWithData = $this->getFullCart();
        

        $total =0; // on calcule le total
        foreach($panierWithData as $item){ //pour tous les produuits du tableau de produit
            $total += $item['produit']->getPrixUnitaireHT()*$item['quantite']; // tu m'ajoutes les articles x les qt au total 
             
        }

        return $total;
     }


     public function  setQt ($id, $action){

        $panier = $this->session->get('panier',[$id]); // On récupere la session avec le panier rempli et on le fout dans $panier
       

        if($action == 'moins'){  
            if ($panier[$id] == 1){
                unset($panier[$id]);
            }else{
        $panier[$id]--;
    }

        }elseif( $action == 'plus' ){
          $panier[$id]++;  
           
        }
    
        $this->session->set('panier', $panier); //on modifie la session avec le nouveau panier tout beau tout propre

     }
}