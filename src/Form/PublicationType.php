<?php

namespace App\Form;

use App\Entity\Publication;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PublicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('mention')
            ->add('publication_date')
            ->add('paging')
            ->add('volume_number')
            ->add('summary')
            ->add('issn_isbn')
            ->add('support')
            ->add('source_address')
            ->add('url')
            ->add('cote')
            ->add('access')
            ->add('type')
            ->add('localisation')
            ->add('thematic')
            ->add('language')
            ->add('editors')
            ->add('bookcollection')
            ->add('authors')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Publication::class,
        ]);
    }
}
