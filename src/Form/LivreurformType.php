<?php

namespace App\Form;

use App\Entity\Livreur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LivreurformType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom', EntityType::class, [           

            'class' => Livreur::class,    
            'multiple'=>false,
            'expanded'=>true
            
                
        ])  
        ->add('submit', SubmitType::class, ['label'=>'Valider la commande']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' =>null,
        ]);
    }
}
