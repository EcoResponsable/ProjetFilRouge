<?php

namespace App\Controller;

use App\Outils\Cart\OutilCart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart")
     */

    public function index( OutilCart $outilCart): Response
    {
      

        $panierWithData = $outilCart->getFullCart();
        $total = $outilCart->getTotal();

       

        return $this->render('cart/index.html.twig', [

            'items'=> $panierWithData,
            'total'=>$total

        ]);
    }


    /**
     * @Route("/cart/add{id}", name="cart_add")
     */

    public function add($id, OutilCart $outilCart): Response //sessionInterface initialise une nouvelle session Infos =>symfony console debug:autowiring session
    {

       $outilCart->add($id);

        
        return $this->redirectToRoute('cart');

    }


    /**
     * @Route("/cart/delete{id}", name="cart_delete")
     */
    public function delete($id,  OutilCart $outilCart ): Response 
    {
        $outilCart->remove($id);
    
        return $this->redirectToRoute('cart');

    }

    
    /** 
     * @Route("/cart/modifQt{id},{action}", name="modifQt")
     */
    public function modifQt($id, $action, OutilCart $outilCart): Response 
    {

        $outilCart->setQt($id, $action);
        
        return $this->redirectToRoute('cart');


    }
}
