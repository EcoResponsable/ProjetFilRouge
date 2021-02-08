<?php

namespace App\Controller;

use App\Form\ClientFormType;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ClientController extends AbstractController
{
    /**
     * @Route("/clientInfo", name="infoClient")
     */
    public function index(): Response
    {

        $commandes = $this->getUser()->getCommandes();
        return $this->render('client/infoClient.html.twig', [
            'role' => 'client',
            'commandes' => $commandes
        ]);
    }


    /**
     * @Route("/clientUpdate", name="clientUpdate")
     */
    public function updateClient(Request $req, EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder): Response
    {

        $user= $this->getUser();
        $form = $this->createForm(ClientFormType::class, $user);
               
      
        $form->handleRequest($req);

            if($form->isSubmitted() && $form->isValid()){
         
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $form->get('password')->getData()
                    )
                );
    
                $em->persist($user);
                $em->flush();
                
            }
        

        return $this->render('client/clientUpdate.html.twig', [
            'form' => $form->createView()
        ]);

    }


    /**
     * @Route("/clientCommandes", name="clientCommandes")
     */
    public function commandes(): Response
    {

        $commandes = $this->getUser()->getCommandes();
        $cm = [];
        
        foreach($commandes as $commande){
            $produits = [];

            $pcs = $commande->getProduitCommandes();

            foreach($pcs as $pc){

                $produits[] = $pc->getProduit();

            }

            $cm[] = $produits;

        }

        return $this->render('client/clientCommandes.html.twig', [
            'role' => 'client',
            'commandes' => $commandes
        ]);
    }
}
