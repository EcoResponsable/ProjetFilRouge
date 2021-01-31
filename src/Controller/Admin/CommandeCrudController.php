<?php

namespace App\Controller\Admin;

use App\Entity\Commande;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
<<<<<<< HEAD
=======
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
>>>>>>> Mehdi
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CommandeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Commande::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            DateField::new('createdAt'),
            TextField::new('client'),
<<<<<<< HEAD
            CollectionField::new('produitCommandes')
=======
            CollectionField::new('produitCommandes'),
            BooleanField::new('isPayed')
>>>>>>> Mehdi
        ];
    }
    
}
