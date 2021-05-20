<?php

namespace App\Form;

use App\Entity\Borrow;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class BorrowType extends AbstractType
{
    private $authorizationChecker;

    public function __construct(AuthorizationCheckerInterface $AuthorizationChecker)
    {
        $this->authorizationChecker = $AuthorizationChecker;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('reservation_date', null, [
            'label' => 'Date de Réservation',
            'widget' => 'single_text',
        ]);
        if ($this->authorizationChecker->isGranted('ROLE_AUDAP_MEMBER')) {
            $builder->add('borrowed_date', null, [
                'label' => 'Date d\'emprunt',
            ]);
            $builder->add('limit_date', null, [
                'label' => 'Date de retour',
            ]);
        };
        $builder->add('comment', null, [
            'label' => 'Commentaire',
        ]);
        $builder->add('user', null, [
            'choice_label' => function ($user) {
                return $user->getFullname();
            },
            'label' => 'Emprunteur : ',
            'required' => true,
        ]);
        $builder->add('publication', null, [
            'choice_label' => 'title',
            'required' => true,
        ]);
        // $builder
        //     ->add('reservation_date', null, [
        //         'label' =>  'Date de Réservation',
        //         'widget' => 'single_text',
        //     ])
        //     ->add('borrowed_date', null, [
        //         'label' =>  'Date d\'emprunt',
        //         'widget' => 'single_text',
        //     ])
        //     ->add('limit_date', null, [
        //         'label' =>  'Date de retour',
        //         'widget' => 'single_text',
        //     ])
        //     ->add('comment', null, ['label' =>  'Commentaire',])
        //     ->add('user', null, [
        //         'choice_label' => function ($user) {
        //             return $user->getFullname();
        //         },
        //         'label' => 'Emprunteur : ',
        //         'required' => true,
        //     ])
        //     ->add('publication', null, [
        //         'choice_label' => 'title',
        //         'required' => true,
        //     ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Borrow::class,
        ]);
    }
}
