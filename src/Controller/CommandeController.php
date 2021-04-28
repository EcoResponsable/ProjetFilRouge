<?php

namespace App\Controller;




use \Mailjet\Resources;
use App\Entity\Adresse;
use App\Entity\CodePromo;
use App\Entity\Commande;
use App\Entity\ProduitCommande;
use App\Form\CodepromoSearchType;
use App\Form\LivreurformType;
use App\Repository\AdresseRepository;
use App\Repository\CodePromoRepository;
use App\Repository\LivreurRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CommandeController extends AbstractController
{
    /**
     * @Route("/clientcommande{adresseLivraison?}", name="commande")
     */
    public function index(SessionInterface $session, ProduitRepository $rep, $adresseLivraison, LivreurRepository $repLivreur, CodePromoRepository $repCode, Request $req): Response
    {

        $user = $this->getUser();
        $adresses = $user->getAdresses();
        $livreur = $repLivreur->findAll();
        $codePromo = $repCode->findAll();
        $montant = 0;
        

        
        
        $produits = $session->get('panier', []);
        $prixTotal = 0;
        $vendeurId=[];
        $panier = [];
        
        foreach($produits as $id => $quantite){
            $panier[] = [
                'produit' => $rep->find($id),
                'quantite' => $quantite
            ];
        }


  
        //Partie du formulaire du livreur
            $livreurForm = $this->createForm(LivreurformType::class, $livreur);
            $livreurForm->handleRequest($req);
            
           
            if ($livreurForm->isSubmitted() && $livreurForm->isValid()){ 
                
                $data = $livreurForm->get('nom')->getData();
                $livreurId = $data->getId();
                $session->set('livreur', $livreurId);
                
                return $this->redirectToRoute('commandeValidate');
                
            }


            foreach($panier as $p){
    
                $prixTotal += ($p['produit']->getPrixUnitaireHT() + ($p['produit']->getPrixUnitaireHT() * $p['produit']->getTVA())) * $p['quantite'];
    
            }
        //*********************************
         
        // Partie du formulaire de code promo
        

        $codeForm = $this->createForm(CodepromoSearchType::class, $codePromo);
        $codeForm->handleRequest($req);
       

         if ($codeForm->isSubmitted()) {

            $data = $codeForm->get('nom')->getData();// on recupere l'entree du formulaire
            
            foreach ($panier as $p){
                  foreach($p as $vendeur){
                    $data1 = $p['produit']->getvendeur()->getId(); // on va rechercher les ID des vendeurs des articles au panier
                    array_push($vendeurId , $data1);
                    
            }
        }
        $vendeurId = array_unique($vendeurId);
    
        $codeTape = $repCode->searchCodePromo($data,$vendeurId);
   

        if ( !$codeTape ){

            dump('Vide');

        }else{
            foreach($codeTape as $c){
               $montant = $c->getMontant();   
               $session->set('codePromo', $montant);     
        }
        
        }
    
            };
    
            return $this->render('commande/index.html.twig', [
                'adresses' =>$adresses,
                'panier' => $panier,
                'prixTotal' => $prixTotal,
                'adresseLivraison'=>$adresseLivraison,
                'livreurs'=>$livreur,
                'codePromoMontant'=>$montant,
                'livreurForm'=>$livreurForm->createView(), 
                'codePromo'=>$codeForm->createView()
               ]);
            
    
          
    }

    /**
     * @Route("/commandeValidate/", name="commandeValidate")
     */
    public function commandeValidate(SessionInterface $session, ProduitRepository $rep, EntityManagerInterface $em, LivreurRepository $repLivreur)
    {
        
        $user = $this->getUser();
        $panier = $session->get('panier');
        $livreurId = $session->get('livreur');
        $codePromo = $session->get('codePromo');
        $livreur = $repLivreur->find($livreurId);
    

        $prixTotal = 0;


        $prixLivraison = $livreur->getTarif();
        

       
        $commande = new Commande();
        $commande
        ->setClient($user)
        ->setLivreur($livreur)
        ->setCodePromo($codePromo)
        ->setReference(date('dmY').'-'.uniqid());

        foreach($panier as $id => $quantite){

            $produitCommande = new ProduitCommande();
            $produitCommande
            ->setQuantite($quantite)
            ->setProduit($rep->find($id))
            ->setCommande($commande);
            
            $em->persist($produitCommande);

            $prod = $rep->find($id);
            $prod->setNbrVendu($prod->getNbrVendu()+ $quantite);
            $em->persist($prod);

            $prix = ($prod->getPrixUnitaireHT() + ($prod->getPrixUnitaireHT() * $prod->getTVA()));
            $prixTotal += $prix*$quantite;
            
        }
        
        $prixTotal += $prixLivraison-$codePromo;
        

       

        $em->persist($commande);
        $em->flush();

       
       return $this->render('commande/commandeValidate.html.twig',[
            'reference' => $commande->getReference(),
            'commande' => $commande,
            'total' => $prixTotal,
        
       ]);
    }



}
