<?php

namespace App\DataFixtures;

use App\Entity\Vendeur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
         
       
        $tabVendeur = ['Vendeur1', 'Vendeur2', 'Vendeur3', 'Vendeur4', 'Vendeur5', 'Vendeur6', 'Vendeur7', 'Vendeur8', 'Vendeur9', 'Vendeur10', 'Vendeur11', 'Vendeur12'];
        

        foreach ($tabVendeur as $key => $value) {

            $vendeur = new Vendeur();
            $vendeur->setNom($value)
            ->setPrenom($value)
            ->setRaisonSociale($value)
            ->setSiret(mt_rand(111111,999999))
            ->setTelephone(mt_rand(1111111111,9999999999))
            ->setAdresse(['Adresse de'.$value])
            ->setDescription('Description du '.$value)
            ->setEmail($value.'@gmail.com')
            ->setPassword($value) 
            ;
            
            $manager->persist($vendeur);

        }

        $manager->flush();
    }
    
}
