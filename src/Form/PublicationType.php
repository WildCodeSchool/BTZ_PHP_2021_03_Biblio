<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Keyword;
use App\Entity\KeywordGeo;
use App\Entity\KeywordRef;
use App\Entity\Publication;
use App\Entity\BookCollection;
use App\Entity\Editor;
use Symfony\Component\Form\AbstractType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class PublicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre de la publication',
                'attr' => ['placeholder' => 'Entrez le nom de la publication'],
            ])
            // ->add('image', UrlType::class, [
            //     'label' => 'Image principale',
            //     'attr' => ['placeholder' => 'Tapez une URL d\'image ']
            // ])
            ->add('imageFile', VichFileType::class, [
                'label' => 'Choisissez une image pour l\'article',
                'attr' => ['placeholder' => 'Veulliez télécharger une image'],
                'required' => false,
                'allow_delete' => true, // not mandatory, default is true
                'download_uri' => true, // not mandatory, default is true
            ])
            
            ->add('thematic', null, [
                'label' => 'Choisissez une thématique'
            ])
            ->add('keywordRefs', EntityType::class, [
                'label' => 'Mots clés référence',
                'class' => KeywordRef::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => false,
                'by_reference' => false
            ])
            ->add('keywordGeos', EntityType::class, [
                'label' => 'Mots clés géographique',
                'class' => KeywordGeo::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => false,
                'by_reference' => false
            ])
            ->add('type')
            ->add('cote')
            ->add('issn_isbn', TextType::class, [
                'label' => 'Numéro de série',
                'attr' => ['placeholder' => 'Veuillez précier le code ISSn ou ISBN'],
            ])
            ->add('localisation')
            ->add('bookcollection', null, [
                'label' => 'Collections'
            ])
            ->add('language', null, [
                'label' => 'Langues'
            ])
            ->add('summary', TextareaType::class, [
                'label' => 'Sommaire',
                'attr' => ['placeholder' => 'Veuillez enbtrer un résumé de la publication'],
            ])
            ->add('mention')
            ->add('paging', NumberType::class, [
                'label' => 'Nombre de pages',
                'required' => false,
                'attr' => ['placeholder' => 'Veuillez préciser le nombre de pages'],
            ])
            ->add('volume_number', TextType::class, [
                'label' => 'Tome n°',
                'attr' => ['placeholder' => 'Entrez le numéro du tome'],
            ])
            ->add('support', TextType::class, [
                'label' => 'Support',
                'attr' => ['placeholder' => 'Veuillez préciser si le support est physique ou digital']
            ])
            ->add('source_address', TextType::class, [
                'label' => 'Support physique: adresse',
                'required' => false,
                'attr' => ['placeholder' => 'Adresse de l\'endroit ou se trouve l\'oeuvre'],
            ])
            ->add('url', TextType::class, [
                'label' => 'Url de la publication',
                'attr' => ['placeholder' => 'Entrez le lien vers la publication'],
                'required' => false,
            ])
            ->add('editors', EntityType::class, [
                'label' => 'Editeurs',
                'class' => Editor::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => false,
                'by_reference' => true
            ])
            ->add('authors', EntityType::class, [
                'label' => 'Auteurs',
                'class' => Author::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => false,
                'by_reference' => true
            ])
            ->add('access', HiddenType::class, [
                'label' => 'Accessibilité',
                'data' => 'null'
            ])
            // ->add('borrows')
            // ->add('user', HiddenType::class, [
            //     'data' => '$this->getUser()->getFullname()'
            // ])
            // ->add('publication_date', HiddenType::class)
            // ->add('update_date', HiddenType::class)
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Publication::class,
        ]);
    }
}
