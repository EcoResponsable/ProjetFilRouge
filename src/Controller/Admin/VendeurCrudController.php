<?php

namespace App\Controller\Admin;

use App\Entity\Vendeur;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class VendeurCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Vendeur::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('email'),
            ArrayField::new('roles'),
            TextField::new('password'),
            IntegerField::new('siret'),
            TextField::new('nom'),
            TextField::new('prenom'),
            TextField::new('raisonSociale'),
            IntegerField::new('telephone'),
            ArrayField::new('adresse'),
            TextEditorField::new('description'),
        ];
    }
    
}
