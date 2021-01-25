<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitFormType;
use App\Form\ProduitUpdateFormType;
use App\Repository\ProduitRepository;
use App\Repository\VendeurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProduitController extends AbstractController
{

     /**
     * @Route("/produitsUpdate", name="produitsUpdate")
     */
    public function produitsUpdate(): Response
    {
        $vendeur = $this->getUser();
        $produits = $vendeur->getProduits();

        return $this->render('produit/produitsUpdate.html.twig', [
            'produits' => $produits,
            'vendeur'=>$vendeur
        ]);
    }


    /**
     * @Route("/vendeur{id}/produit", name="produitsVendeur")
     */
    public function index(VendeurRepository $rep,$id): Response
    {

        $vendeur = $rep->find($id);
        $produits = $vendeur->getProduits();

        return $this->render('produit/produitsVendeur.html.twig', [
            'produits' => $produits,
            'vendeur'=>$vendeur
        ]);
    }


     /**
     * @Route("/produit{id}", name="deleteProduits")
     */
    public function deleteProduits( $id ,ProduitRepository $rep, EntityManagerInterface $em)
    {
        $produit = $rep->find($id);
    
        $em->remove($produit); 
        $em->flush(); 

        return $this->redirectToRoute('produitsUpdate');
        
    }

    
     /**
     * @Route("/addProduit", name="addProduit")
     */
    public function addProduit(EntityManagerInterface $em, Request $req)
    {
      
        $produit = new Produit();

        $vendeur = $this->getUser();
        $produit->setVendeur($vendeur);

        $form = $this->createForm(ProduitFormType::class, $produit);

        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid()){


            $upload = $form['image']->getData();
            $upload->move('images', $produit->getNom().'.jpg');       
            $produit->setImage('images/'.$produit->getNom().'.jpg');

            

            $em->persist($produit);
            $em->flush();
        }

        return $this->render('produit/produitAdd.html.twig', [
            'form' => $form->createView()
        ]);
        
    }

      /**
     * @Route("/updateProduit{id}", name="updateProduit")
     */
    public function updateProduit(ProduitRepository $rep,$id, EntityManagerInterface $em, Request $req)
    {
      
        $produit = $rep->find($id);

         
        $vendeur = $this->getUser();
        $produit->setVendeur($vendeur);

        $form = $this->createForm(ProduitUpdateFormType::class, $produit);

        $form->handleRequest($req);

        if($form->isSubmitted() && $form->isValid()){


        
            $em->persist($produit);
            $em->flush();
        }

        return $this->render('produit/produitUpdate.html.twig', [
            'form' => $form->createView()
        ]);
        
    }


    

    
}
