<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Vendeur;
use App\Form\ClientFormType;
use App\Form\VendeurFormType;
use App\Security\AppAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class RegistrationController extends AbstractController
{


    /**
     * @Route("/inscription/{type?client}", name="register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, AppAuthenticator $authenticator,$type): Response
    {
        if($type == 'client'){
            $user = new Client();
            $form = $this->createForm(ClientFormType::class, $user);
        }elseif($type == 'vendeur'){
            $user = new Vendeur();
            $form = $this->createForm(VendeurFormType::class, $user);
        }
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render($type.'/'.$type.'register.html.twig', [
            'registrationForm' => $form->createView(),
            'type' => $type
        ]);
    }
}
