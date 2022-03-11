<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;



class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prenom')
            ->add('nom')
            ->add('email')
            ->add('password', RepeatedType::class , [
                    'type' => PasswordType::class,
                    'invalid_message' => 'Les mots de passe saisis ne correspondent pas.',
                    'options' => ['attr' => ['class' => 'password-field']],
                    'required' => true,
                    'first_options' => ['label' => 'Mot de passe'],
                    'second_options' => ['label' => 'Répétez la saisie du mot de passe'],



            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
