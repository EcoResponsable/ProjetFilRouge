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
     * @Route("/panierUpdate/{id}/{action?}", name="panierUpdate")
     */
    public function panierUpdate(SessionInterface $session, Request $request,$id,$action): Response
    {

        $panier = $session->get('panier',[]);

        if($action == 'moins'){            
            if($panier[$id] == 1){
                unset($panier[$id]);
            }else{
                $panier[$id]--;
            }
        }else{
            empty($panier[$id]) ? $panier[$id] = 1 : $panier[$id]++;
        };
        
        $session->set('panier',$panier);
 
        // if($action != 'plus'){
        
            return $this->json(['Qt'=>$panier[$id]],200);

        // }else{

        // return $this->redirect($request->headers->get('referer'));
        // };
       

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

  



}
