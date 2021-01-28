<?php

namespace App\DataFixtures;

use App\Entity\Adresse;
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

       for($i = 1 ; $i <=10 ; $i++){
           $tabVendeur[] = 'Vendeur'.$i;
       }        

        foreach ($tabVendeur as $value) {

            $adresse = new Adresse();
            $adresse
            ->setNom('Michel')
            ->setPrenom('André')
            ->setRue('35 Rue des lilas')
            ->setVille('Paris')
            ->setCodePostal('75018')
            ->setPays('France');
            
            
            $vendeur = new Vendeur();
            $password = $this->encoder->encodePassword($vendeur, $value);
            $vendeur->setNom($value)
            ->setPrenom($value)
            ->setRaisonSociale($value)
            ->setSiret(mt_rand(111111,999999))
            ->setTelephone(mt_rand(1111111111,9999999999))
            ->setDescription('Description du '.$value)
            ->addAdress($adresse)
            ->setEmail($value.'@gmail.com')
            ->setPassword($password)
            ;
            $manager->persist($adresse);
            $manager->persist($vendeur);

            for($j = 1 ; $j <=10 ; $j++){
            $produit = new Produit();
            $produit->setNom('produit '.$j.' du '.$value)
            ->setDescription('Une Description Ici')
            ->setStock(rand(50,500))
            ->setPoidUnitaire(300)
            ->setPrixUnitaireHT(fdiv(rand(500,2000),100))
            ->setImage('images/produit'.$j.'.jpg')
            ->setVendeur($vendeur);
            
            
            $manager->persist($produit);

            }
        }

        for($k = 1 ; $k <=30 ; $k++){
            
            $tabClient[] = 'Client'.$k;
        }        
 
         foreach ($tabClient as $value) {
 
            $adresse = new Adresse();
            $adresse
            ->setNom('Dupont')
            ->setPrenom('Michelle')
            ->setRue('50 avenue des chataignes')
            ->setVille('Gisors')
            ->setCodePostal('27140')
            ->setPays('France');
            $client = new Client();
            $password = $this->encoder->encodePassword($client, $value);
            $client->setNom($value)
            ->setPrenom($value)
            ->setPaiement(['mastercard'
            ])
            ->setTelephone(mt_rand(1111111111,9999999999))
            ->addAdress($adresse)
            ->setEmail($value.'@gmail.com')
            ->setPassword($password)
            ;
            
            $manager->persist($adresse);
            $manager->persist($client);
 
         }

        $manager->flush();
    }
    
}
