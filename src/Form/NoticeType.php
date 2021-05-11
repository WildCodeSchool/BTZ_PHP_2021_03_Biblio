<?php

namespace App\Form;

use App\Entity\Notice;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NoticeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('summary')
            ->add('creation_date')
            ->add('publication')
            ->add('author')
            //->add('user')
            ->add('user', null, ['choice_label' => function ($user) {
                $roles = $user->getRoles();

                return $user->getDisplayName().' -  '.implode(' | ', $roles);
                // return $user->getFirstname().' '.$user->getLastname();
            }])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Notice::class,
        ]);
    }
}
