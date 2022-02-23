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
use App\Entity\Entreprise;
//use Symfony\Component\Validator\Constraints\NotBlank;

class StageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre',TextType::class,['label'=>'Titre du stage'])
            ->add('missions',TextareaType::class,['label'=>'La mission'])
            ->add('contact',TextType::class,['label'=>'Contact'])
            ->add('codeEntreprise',EntrepriseType::class,['label'=>'L\'entreprise proposant le stage'])
            ->add('codeFormation',EntityType::class,array(
                'class'=> Formation::class,
                'label'=>'Formation(s) proposée(s)',
                
                'choice_label'=>function(Formation $formations,)
                {return $formations->getNom();},
                'multiple'=>true,
                'expanded'=>true,
                

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
