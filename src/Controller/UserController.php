<?php

namespace App\Controller;

use App\Form\VendeurFormType;
use App\Repository\AdminRepository;
use App\Repository\ClientRepository;
use App\Repository\VendeurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/user{role}{id}", name="user")
     */
    public function index($role,$id, AdminRepository $repAdmin, ClientRepository $repClient, VendeurRepository $repVendeur, Request $req, EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder): Response
    {

        switch($role){
            case 'ROLE_ADMIN':
                $user = $repAdmin->find($id);
                break;
            case 'ROLE_VENDEUR':
                $user = $repVendeur->find($id);
                $form = $this->createForm(VendeurFormType::class, $user);
                break;
            case 'ROLE_CLIENT':
                $user = $repClient->find($id);
                $form = $this->createForm(ClientFormType::class, $user);
                break;
        }

        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $em->persist($user);
            $em->flush();
        }



        return $this->render('user/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
