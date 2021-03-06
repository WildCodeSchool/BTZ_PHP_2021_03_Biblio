<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Prénom'
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('phone', NumberType::class, [
                'label' => 'Tel',
                'invalid_message' => 'Veuillez saisir seulement des chiffres pour votre numéro de téléphone.',
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse'
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email'
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe et la confirmation doivent être identique',
                'required' => true,
                'label' => 'mot de passe',
                'first_options' => ['label' => 'Votre mot de passe' ],
                'second_options' => ['label' => 'Confirmez votre mot de passe']
            ])
            // ->add('newsletter', CheckboxType::class, [
            //      'required' => false,
            //     'label' => 'Souhaitez-vous être inscrit à la newsletters de l\' Audap ?',
            // ])
            ->add('newsletter', HiddenType::class)
            ->add('slug', HiddenType::class)
            ->add('submit', SubmitType::class, [
                'label' => 'S\'inscrire',
                'attr' => [
                    'class' => 'btn btn-success btn block'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
