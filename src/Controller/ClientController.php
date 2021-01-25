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
        return $this->render('client/infoClient.html.twig', [
            'role' => 'client',
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
        

                    return $this->render('vendeur/vendeurUpdate.html.twig', [
                        'form' => $form->createView()
                    ]);

    }
}
