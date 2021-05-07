<?php

namespace App\DataFixtures;

use App\Entity\Adresse;
use App\Entity\Client;
use App\Entity\Livreur;
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
            ->setDescription('Lorem ipsum, dolor sit amet consectetur adipisicing elit. Cum quidem quo enim minima soluta necessitatibus quis iusto beatae, culpa assumenda rerum, suscipit laborum impedit error obcaecati alias ex? Saepe, molestias!')
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

         $l1 = new Livreur();
        $l1->setNom('Livreur1')->setDescription(' Modi optio delectus officia deleniti possimus consequuntur? Ipsa delectus quam eos, ipsum distinctio aliquid dolores ex corporis voluptate quis consequatur inventore maxime.')->setTarif(5);
        $manager->persist($l1);

        $l2 = new Livreur();
        $l2->setNom('Livreur2')->setDescription(' Animi facilis facere unde debitis voluptatibus rem repellendus quasi esse error veritatis, blanditiis harum, magnam necessitatibus recusandae fugiat iusto sapiente. Deserunt, adipisci.')->setTarif(2);
        $manager->persist($l2);

        $l3 = new Livreur();
        $l3->setNom('Livreur3')->setDescription('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Tenetur consequatur officiis, cum necessitatibus maxime animi possimus ipsa sapiente rerum mollitia explicabo voluptas dignissimos, eius dolor deserunt ea sit, in delectus.')->setTarif(10);
        $manager->persist($l3);

        $manager->flush();
    }
    
}
