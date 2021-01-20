<?php

namespace App\Controller;

use App\Entity\Client;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function index(EntityManagerInterface $em): Response
    {
        // $client = new Client();
        // $client
        // ->setEmail('mehdi.agounine@gmail.com')
        // ->setPassword('mathys')
        // ->setNom('Agounine')
        // ->setPrenom('Mehdi');

        // $em->persist($client);
        // $em->flush();



        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }

    /**
     * @Route("/succes", name="succes")
     */
    public function succes(): Response
    {
        return $this->render('accueil/succes.html.twig', [
        ]);
    }
}
