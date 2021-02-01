<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Form\AdresseFormType;
use App\Repository\AdresseRepository;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdresseController extends AbstractController
{
    /**
     * @Route("/adresse", name="adresse")
     */
    public function index(): Response
    {
        $user = $this->getUser();
        $adresses = $user->getAdresses();
        return $this->render('adresse/index.html.twig', [
            'adresses' => $adresses,
        ]);
    }

    /**
     * @Route("/adresseAdd{id?}", name="adresseAdd")
     */
    public function add(Request $request, EntityManagerInterface $em, $id): Response
    {


        $adresse = new Adresse();
        $form = $this->createForm(AdresseFormType::class,$adresse);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $user = $this->getUser();
            $adresse->addUser($user);

            $em->persist($adresse);
            $em->flush();
            dump($user);
                if($id == null){
                     return $this->redirectToRoute('adresse');
                 }else{

                    return $this->redirectToRoute('commande');
                 }
        }

        return $this->render('adresse/adresseAdd.html.twig', [
            'form' => $form->createView(),
        ]);
    }

     /**
     * @Route("/adresseDelete{id}", name="adresseDelete")
     */
    public function adresseDelete($id, AdresseRepository $rep, EntityManagerInterface $em): Response
    {

        $adresse = $rep->find($id);
        
        $em->remove($adresse);
        $em->flush();


        return $this->redirectToRoute('adresse');
    }

    /**
     * @Route("/setDefault{id}", name="setDefault")
     */
    public function setDefault($id, EntityManagerInterface $em): Response
    {

        $user = $this->getUser();
        $adresses = $user->getAdresses();

        foreach ($adresses as $adresse){

            if($adresse->getIsDefault() == true){

                $adresse->setIsDefault(false);
                $em->persist($adresse);

            }elseif($adresse->getId() == $id){

                $adresse->setIsDefault(true);
                $em->persist($adresse);

            }
            
        }
        $em->flush();


        $em->flush();
     
        return $this->redirectToRoute('adresse');
    }

    /**
     * @Route("/adresseLivraison{id}", name="adresseLivraison")
     */
    public function adresseLivraison(Adresserepository $rep, $id): Response
    {
        $user = $this->getUser();
        $adresses = $user->getAdresses();
        $adresseLivraison = $rep->Find($id);
      

        return $this->redirectToRoute('commande', [
            'adresseLivraison' => $adresseLivraison,
            'adresses' => $adresses,
        ]);
    }
    
}
