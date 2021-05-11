<?php

namespace App\Form;

use App\Entity\PublicationType;
use App\Entity\Thematic;
use App\Entity\Author;
use App\Entity\Keyword;
use App\Entity\KeywordRef;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\Factory\Cache\ChoiceLabel;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchPublicationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type_search', EntityType::class, [
                'class' => PublicationType::class,
                'required' => false,
                'choice_label' => 'name',
            ])
            ->add('thematic_search', EntityType::class, [
                'class' => Thematic::class,
                'required' => false,
                'choice_label' => 'name',
            ])
            ->add('author_search', EntityType::class, [
                'class' => Author::class,
                'required' => false,
                'choice_label' => 'name',
            ])
            ->add('keyword_search', EntityType::class, [
                'class' => KeywordRef::class,
                'required' => false,
                'choice_label' => 'name',
            ])
            ->add('keywordGeo_search', EntityType::class, [
                'class' => KeywordRef::class,
                'required' => false,
                'choice_label' => 'name',
            ])
            ->add('dateStart_search', DateType::class, [
                'widget' => 'choice',
                'required' => false,
            ])
            ->add('dateEnd_search', DateType::class, [
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
