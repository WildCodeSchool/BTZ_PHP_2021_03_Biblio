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
        $builder->add('type_search', EntityType::class, [
                 'class' => PublicationType::class,
                 'required' => false,
                 'choice_label' => 'name',
             ]);
        $builder->add('thematic_search', EntityType::class, [
                'class' => Thematic::class,
                'required' => false,
                'choice_label' => 'name',
            ]);
        $builder->add('author_search', EntityType::class, [
                'class' => Author::class,
                'required' => false,
                'choice_label' => 'name',
            ]);
        $builder->add('keywordRef_search', EntityType::class, [
                'class' => KeywordRef::class,
                'required' => false,
                'choice_label' => 'name',
            ]);
        $builder->add('keywordGeo_search', EntityType::class, [
                'class' => KeywordGeo::class,
                'required' => false,
                'choice_label' => 'name',
            ]);
        if ($this->authorizationChecker->isGranted('ROLE_AUDAP_MEMBER')) {
            $builder->add('borrow_search', EntityType::class, [
                    'class' => User::class,
                    'required' => false,
                    'choice_label' => 'fullname',
                ]);
            $builder->add('cote_search', null, [
                    'required' => false,
                ]);
        }
        
        $builder->add('dateStart_search', DateType::class, [
                'widget' => 'choice',
                'required' => false,
            ]);
        $builder->add('dateEnd_search', DateType::class, [
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
