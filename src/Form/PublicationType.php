<?php

namespace App\Form;

use App\Entity\Keyword;
use App\Entity\Publication;
use Symfony\Component\Form\AbstractType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PublicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre de la publication',
                'attr' => ['placeholder' => 'Entrez le nom de la publication']
            ])
            // ->add('image', UrlType::class, [
            //     'label' => 'Image principale',
            //     'attr' => ['placeholder' => 'Tapez une URL d\'image ']
            // ])
            ->add('imageFile', VichFileType::class, [
                'label' => 'Choisissez une image pour l\'article',
                'attr' => ['placeholder' => 'Veulliez télécharger une image'],
                'required'      => false,
                'allow_delete'  => true, // not mandatory, default is true
                'download_uri' => true, // not mandatory, default is true
            ])
            // ->add('publication_date')
            ->add('thematic')
            ->add('keywordRefs')
            ->add('keywordGeos')
            ->add('type')
            ->add('cote')
            ->add('issn_isbn', TextType::class, [
                'label' => 'Numéro de série',
                'attr' => ['placeholder' => 'Veuillez précier le code ISSn ou ISBN']
            ])
            ->add('localisation')
            ->add('bookcollection')
            ->add('language')
            ->add('summary', TextareaType::class, [
                'label' => 'Sommaire',
                'attr' => ['placeholder' => 'Veuillez enbtrer un résumé de la publication']
            ])
            ->add('mention')
            ->add('paging', NumberType::class, [
                'label' => 'Nombre de pages',
                'attr' => ['placeholder' => 'Veuillez préciser le nombre de pages']
            ])
            ->add('volume_number', TextType::class, [
                'label' => 'Tome n°',
                'attr' => ['placeholder' => 'Entrez le numéro du tome']
            ])
            ->add('support', TextType::class, [
                'label' => 'Support',
                'attr' => ['placeholder' => 'veillez préciser si le support est physique ou digital']
            ])
            ->add('source_address', TextType::class, [
                'label' => 'Support physique: adresse',
                'attr' => ['placeholder' => 'Adresse de l\'endroit ou se trouve l\'oeuvre']
            ])
            ->add('url', TextType::class, [
                'label' => 'Url de la publication',
                'attr' => ['placeholder' => 'Entrez le lien vers la publication']
            ])
            ->add('editors')
            ->add('authors')
            ->add('access')
            ->add('borrows')
            ->add('user')
            ->add('update_date', null, [
                'widget' => 'single_text'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Publication::class,
        ]);
    }
}