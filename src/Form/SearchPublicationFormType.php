<?php

namespace App\Form;

use App\Entity\PublicationTP;
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
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SearchPublicationFormType extends AbstractType
{
    private $authorizationChecker;
    private $tabSearch = [
        'type_search' => null,
        'thematic_search' => null,
        'author_search' => null,
        'keywordRef_search' => null,
        'keywordGeo_search' => null,
        'borrow_search' => null,
        'cote_search' => null,
        'dateStart_search' => null,
        'dateEnd_search' => null,
    ];

    public function __construct(AuthorizationCheckerInterface $AuthorizationChecker, SessionInterface $session)
    {
        $this->authorizationChecker = $AuthorizationChecker;
        if ($session->has('search_pub')) {
            $tab = $session->get('search_pub');
            foreach ($this->tabSearch as $key => $value) {
                if (isset($tab[$key]) && $tab[$key] !== null) {
                    $this->tabSearch[$key] = $tab[$key];
                }
            }
        };
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {

        // }));

        $builder->add('type_search', EntityType::class, [
                 'class' => PublicationTP::class,
                 'label' => 'Type de publication',
                 'required' => false,
                //  'placeholder' => $this->tabSearch['type_search'] !== null ? $this->tabSearch['type_search']->getName(): ' ',
                 'choice_label' => 'name',
             ]);
        $builder->add('thematic_search', EntityType::class, [
                'class' => Thematic::class,
                'label' => 'Thématique',
                // 'placeholder' => $this->tabSearch['thematic_search'] !== null ? $this->tabSearch['thematic_search']->getName(): ' ',
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
