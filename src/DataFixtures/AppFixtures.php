<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\Panier;
use App\Entity\Produit;
use App\Entity\Vendeur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
       for($i = 1 ; $i <=30 ; $i++){
           $tabVendeur[] = 'Vendeur'.$i;
       }        

        foreach ($tabVendeur as $value) {

            
            $vendeur = new Vendeur();
            $password = $this->encoder->encodePassword($vendeur, $value);
            $vendeur->setNom($value)
            ->setPrenom($value)
            ->setRaisonSociale($value)
            ->setSiret(mt_rand(111111,999999))
            ->setTelephone(mt_rand(1111111111,9999999999))
            ->setAdresse(['Adresse de'.$value])
            ->setDescription('Description du '.$value)
            ->setEmail($value.'@gmail.com')
            ->setPassword($password)
            ;
            $manager->persist($vendeur);

            for($i = 1 ; $i <=10 ; $i++){
            $produit = new Produit();
            $produit->setNom('produit '.$i.' du '.$value)
            ->setDescription('Une Description Ici')
            ->setStock(rand(50,500))
            ->setPoidUnitaire(300)
            ->setPrixUnitaireHT(fdiv(rand(500,2000),100))
            ->setImage('images/'.$value.'.jpg')
            ->setVendeur($vendeur);
            
            
            $manager->persist($produit);

            }
        }

        for($i = 1 ; $i <=30 ; $i++){
            
            $tabClient[] = 'Client'.$i;
        }        
 
         foreach ($tabClient as $value) {
 
             
             $client = new Client();
             $password = $this->encoder->encodePassword($client, $value);
             $client->setNom($value)
             ->setPrenom($value)
             ->setTelephone(mt_rand(1111111111,9999999999))
             ->setAdresse([
                 'Adresse de'.$value
                 ])
             ->setPaiement(['mastercard'
             ])
             ->setEmail($value.'@gmail.com')
             ->setPassword($password)
             ;
             
             $manager->persist($client);

            $panier = new Panier();
            $panier->setPrixTotalTTC(0)->setClient($client);
            $manager->persist($panier);
 
         }

        $manager->flush();
    }
    
}
