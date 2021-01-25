<?php

namespace App\Controller;

use App\Form\VendeurFormType;
use App\Repository\VendeurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class VendeurController extends AbstractController
{
    /**
     * @Route("/allVendeurs", name="allVendeurs")
     */
    public function allVendeurs( VendeurRepository $rep): Response
    {
        $vendeurs = $rep->findAll();

        return $this->render('vendeur/allVendeurs.html.twig', [
            'vendeurs'=>$vendeurs,
        ]);
    }

    /**
         * @Route("/infoVendeur", name="infoVendeur")
         */
        public function infoUser()
        {   

        return $this->render('vendeur/infoVendeur.html.twig',[
            'role' => 'vendeur'
        ]);

        }

    /**
     * @Route("/vendeurUpdate", name="vendeurUpdate")
     */
    public function updateVendeur( Request $req, EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder): Response
    {

        $user= $this->getUser();
        $form = $this->createForm(VendeurFormType::class, $user);
               
      
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
