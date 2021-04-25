<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    /**
     * @Route("/panier", name="panier")
     */
    public function panier(SessionInterface $session, EntityManagerInterface $em, ProduitRepository $rep): Response
    {

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
            
        
        return $this->render('panier/panier.html.twig', [
            'panier' => $panier,
            'prixTotal' => $prixTotal
        ]);
    }

    /**
     * @Route("/panierUpdate/{id}/{action?}/", name="panierUpdate")
     */
    public function panierUpdate(SessionInterface $session, Request $request,$id,$action, ProduitRepository $rep): Response
    {
   
        $produit = $rep->find($id);
        $prixHT = $produit->getPrixUnitaireHT();
        $TVA = $produit->getTVA();
        $quantiteProduit = $session->get('panier', []);


        if($action == 'moins'){   

            if($quantiteProduit[$id] == 1){
                unset($quantiteProduit[$id]);
            }else{
                $quantiteProduit[$id]--;
                $prix = (($prixHT*$TVA)+$prixHT)*$quantiteProduit[$id];
                $prix = number_format($prix, 2);
             
            }
        }else{
            empty($quantiteProduit[$id]) ? $quantiteProduit[$id] = 1 : $quantiteProduit[$id]++;
            $prix = (($prixHT*$TVA)+$prixHT)*$quantiteProduit[$id];
            $prix = number_format($prix, 2); 
        };

        $session->set('panier',$quantiteProduit);




        // ***********************PRIX TOTAL********************************

        
        $prixTotal = 0;
        $produits = $session->get('panier', []);
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
        $prixTotal = number_format($prixTotal, 2); 

        


        return $this->json(['Qt'=>$quantiteProduit[$id], 'prix'=>$prix, 'prixTotal' => $prixTotal],200);


    }

    /**
     * @Route("/panierDelete{id?}", name="panierDelete")
     */
    public function panierDelete(SessionInterface $session,$id, Request $request): Response
    {

        $panier = $session->get('panier',[]);

        if ($id){
            unset($panier[$id]);
            $session->set('panier',$panier);
            return $this->redirect($request->headers->get('referer'));
        }else{
            $session->set('panier', []); 
            return $this->redirectToRoute('panier');
        } 

    }

  
/**
     * @Route("/panierAjout/{id}/", name="panierAjout")
     */
    public function panierAjout(SessionInterface $session, Request $request,$id): Response
    {

        $panier = $session->get('panier',[]);

        
        empty($panier[$id]) ? $panier[$id] = 1 : $panier[$id]++; 
        $session->set('panier',$panier);
       
 
        
            return $this->json(['Qt'=>$panier[$id], "message"=>"dans votre panier"],200);


    }


}
