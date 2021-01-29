<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StripeController extends AbstractController
{
    /**
     * @Route("/stripe/{reference}", name="stripe")
     */
    public function index($reference,EntityManagerInterface $em,CommandeRepository $rep): Response
    {

        \Stripe\Stripe::setApiKey('sk_test_51IEsCZKW6V2JlCa641c1pQGFTHrMFPRb1msZrQBEdPonmxK9Y334i1YrP2UZUnuwwTraPy9qCi2J1zcw9thmSKjp00SqLjkdM7');

        $commande = $rep->findOneBy(['reference'=>$reference]);
        $url = "http://127.0.0.1:8000";
        $prodStripe = [];

        foreach($commande->getProduitCommandes() as $produitCommande){
            $produit = $produitCommande->getProduit();

            $prodStripe[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => floor($produit->getPrixUnitaireHT() + ($produit->getPrixUnitaireHT() * $produit->getTVA())) *100,
                    'product_data' => [
                        'name' => $produit->getNom(),
                        'images' => ['public/'.$produit->getImage()]
                    ]
                ],
                'quantity' => $produitCommande->getQuantite()
            ];
        }
        
        $checkout_session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $prodStripe,
            'mode' => 'payment',
            'success_url' => $url . '/clientInfo',
            'cancel_url' => $url . '/panier',
          ]);

        return new JsonResponse(['id' => $checkout_session->id]);


        //return $this->render('stripe/index.html.twig');
    }
}
