<?php

namespace App\Form;

use App\Entity\Publication;
use App\Entity\Keyword;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PublicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('thematic')
            ->add('type')
            ->add('cote')
            ->add('keywords', null, ['choice_label' => 'name'])
            ->add('localisation')
            ->add('bookcollection')
            ->add('language')
            ->add('summary')
            ->add('mention')
            ->add('publication_date')
            ->add('paging')
            ->add('volume_number')
            ->add('issn_isbn')
            ->add('support')
            ->add('source_address')
            ->add('url')
            ->add('editors')
            ->add('authors')
            ->add('notices')
            ->add('access')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Publication::class,
        ]);
    }
}
