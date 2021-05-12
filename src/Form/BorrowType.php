<?php

namespace App\Form;

use App\Entity\Borrow;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BorrowType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reservation_date')
            ->add('borrowed_date')
            ->add('limit_date')
            ->add('comment')
            ->add('user',null, 
                    ['choice_label' => function ($user) {return $user->getFullname();
                },
            'label' => 'Attribuer un utilisateur a l emprunt : ',
            'required' => true,
            ])
            ->add('publication',null, ['choice_label' => 'title',
            'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Borrow::class,
        ]);
    }
}
