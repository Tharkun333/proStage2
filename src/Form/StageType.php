<?php

namespace App\Form;

use App\Entity\Stage;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Formation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\Common\Collections\ArrayCollection;
use App\Form\EntrepriseType;

class StageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre',TextType::class)
            ->add('missions',TextType::class)
            ->add('contact',TextareaType::class)
            ->add('codeEntreprise',EntrepriseType::class)
            ->add('codeFormation',EntityType::class,array(
                'class'=> Formation::class,
                'choice_label'=>function(Formation $formations)
                {return $formations->getNom();},
                'multiple'=>true,
                'expanded'=>true
                





            ))
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stage::class,
        ]);
    }
}
