<?php

namespace App\Controller;

use App\Entity\Panier;
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

            foreach($produits as $id => $quantite){
                $panier[] = [
                    'produit' => $rep->find($id),
                    'quantite' => $quantite
                ];
            }

            foreach($panier as $p){
                $prixTotal += $p['produit']->getPrixUnitaireHT() * $p['quantite'];
            }
            
        
        return $this->render('panier/panier.html.twig', [
            'panier' => $panier,
            'prixTotal' => $prixTotal
        ]);
    }

    /**
     * @Route("/panierAdd{id}", name="panierAdd")
     */
    public function panierAdd(SessionInterface $session,$id, Request $request): Response
    {

        $panier = $session->get('panier',[]);
        if(empty($panier[$id])){
            $panier[$id] = 1;
        }else{
            $panier[$id]++;
        };
        
        $session->set('panier',$panier);

        return $this->redirect($request->headers->get('referer'));

    }

    /**
     * @Route("/panierSub{id}", name="panierSub")
     */
    public function panierSub(SessionInterface $session,$id, Request $request): Response
    {

        $panier = $session->get('panier',[]);

        if($panier[$id] > 1){
            $panier[$id]--;
        }else{
            unset($panier[$id]);
        };
        
        $session->set('panier',$panier);

        return $this->redirect($request->headers->get('referer'));

    }

    /**
     * @Route("/panierDelete{id}", name="panierDelete")
     */
    public function panierDelete(SessionInterface $session,$id, Request $request): Response
    {

        $panier = $session->get('panier',[]);

        unset($panier[$id]);
        
        $session->set('panier',$panier);

        return $this->redirect($request->headers->get('referer'));

    }

}
