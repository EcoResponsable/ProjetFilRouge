<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Connexion;
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

        $connexion = new Connexion();
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }

    /**
     * @Route("/client", name="accueilclient")
     */
    public function indexclient(EntityManagerInterface $em): Response
    {
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }

    /**
     * @Route("/vendeur", name="accueilvendeur")
     */
    public function indexvendeur(EntityManagerInterface $em): Response
    {
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }

    /**
     * @Route("/succes", name="succes")
     */
    public function succes(EntityManagerInterface $em): Response
    {
        $connexion = new Connexion();

        $user = $this->getUser();
        $connexion->setUser($user);
        $date = new \DateTime();
        $connexion->setDateConnexion($date);
        $em->persist($connexion);
        $em->flush();
        
        return $this->render('accueil/succes.html.twig', [
        ]);
    }
}
