<?php

namespace App\Controller;

use App\Entity\CodePromo;
use App\Entity\Vendeur;
use App\Form\CodepromoSearchType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\CodePromoType;
use App\Repository\CodePromoRepository;


class CodePromoController extends AbstractController
{
    /**
     * @Route("/addCodePromo={id}", name="addCodePromo")
     */
    public function addCodePromo(EntityManagerInterface $em, Request $req, $id)
    {
      
        $CodePromo = new CodePromo();
        
        $form = $this->createForm(CodePromoType::class, $CodePromo);
        $form->handleRequest($req);
        
        $vendeur = $this->getUser();
        $CodePromo->setDateDebut(new \DateTime('now'));
        $CodePromo->setvendeurId($vendeur);
        
        if($form->isSubmitted() && $form->isValid()){
            
            $em->persist($CodePromo);
            $em->flush();
            
            return $this->redirectToRoute('allCodePromo',[
                'id'=>$id
                ]
            );
        }
        
        return $this->render('codePromo/addCode.html.twig', [
            'Form' => $form->createView(),
            
            ]);
            
        }
        
        /**
         * @Route("/allCodePromo={id}", name="allCodePromo")
         */
        public function allCodePromo(CodePromoRepository $rep, $id)
        {
            
            $CodePromo = $rep->findBy(['vendeurId'=>$id]);
            $dateActuelle = (new \DateTime('now'));

        return $this->render('codePromo/index.html.twig', [
            'CodesPromo' => $CodePromo,
            'dateActuelle' => $dateActuelle
        ]);
        
    }


      /**
         * @Route("/deletCodePromo={id}={idCode}", name="deletCodePromo")
         */
        public function deletCodePromo(CodePromoRepository $rep, $id, $idCode, EntityManagerInterface $em)
        {
            $code = $rep->find($idCode);
            $em->remove($code);
            $em->flush();
        
            return $this->redirectToRoute('allCodePromo',[
                'id'=>$id
                ]
            );
        
    }

       /**
         * @Route("/codePromo", name="codePromo")
         */
        public function CodePromo(CodePromoRepository $rep, $id, $idCode, EntityManagerInterface $em)
        {
            $code = $rep->find($idCode);
            $em->remove($code);
            $em->flush();
        
            return $this->redirectToRoute('allCodePromo',[
                'id'=>$id
                ]
            );
        
    }
    
     
    }
