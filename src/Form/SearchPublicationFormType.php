<?php

namespace App\Form;

use App\Entity\PublicationType;
use App\Entity\Thematic;
use App\Entity\Author;
use App\Entity\User;
use App\Entity\KeywordGeo;
use App\Entity\KeywordRef;
use Proxies\__CG__\App\Entity\KeywordGeo as EntityKeywordGeo;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\AuthorizationChecker\Core\AuthorizationChecker;
use Symfony\Component\Form\ChoiceList\Factory\Cache\ChoiceLabel;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class SearchPublicationFormType extends AbstractType
{
    private $authorizationChecker;

    public function __construct(AuthorizationCheckerInterface $AuthorizationChecker)
    {
        $this->authorizationChecker = $AuthorizationChecker;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {

        // }));
        
        $builder->add('type_search', EntityType::class, [
                 'class' => PublicationType::class,
                 'label' => 'Type de publication',
                 'required' => false,
                 'choice_label' => 'name',
             ]);
        $builder->add('thematic_search', EntityType::class, [
                'class' => Thematic::class,
                'label' => 'Thématique',
                'required' => false,
                'choice_label' => 'name',
            ]);
        $builder->add('author_search', EntityType::class, [
                'class' => Author::class,
                'label' => 'Auteur',
                'required' => false,
                'choice_label' => 'name',
            ]);
        $builder->add('keywordRef_search', EntityType::class, [
                'class' => KeywordRef::class,
                'label' => 'Mot clé',
                'required' => false,
                'choice_label' => 'name',
            ]);
        $builder->add('keywordGeo_search', EntityType::class, [
                'class' => KeywordGeo::class,
                'label' => 'Mot clé géographique',
                'required' => false,
                'choice_label' => 'name',
            ]);
        if ($this->authorizationChecker->isGranted('ROLE_AUDAP_MEMBER')) {
            $builder->add('borrow_search', EntityType::class, [
                    'class' => User::class,
                    'label' => 'Emprunteur',
                    'required' => false,
                    'choice_label' => 'fullname',
                ]);
            $builder->add('cote_search', null, [
                    'label' => 'Cote',
                    'required' => false,
                ]);
        }
        
        $builder->add('dateStart_search', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date publication début',
                'required' => false,
                'format' => 'yyyy-MM-dd',
            ]);
        $builder->add('dateEnd_search', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de publication fin',
                'required' => false,
                'format' => 'yyyy-MM-dd',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
