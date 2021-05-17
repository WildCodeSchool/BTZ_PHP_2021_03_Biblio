<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\BookCollection;
use App\Entity\Borrow;
use App\Entity\Editor;
use App\Entity\Keyword;
use App\Entity\KeywordRef;
use App\Entity\Language;
use App\Entity\Localisation;
use App\Entity\PublicationType;
use App\Entity\Thematic;
use App\Entity\User;
use App\Form\AuthorType;
use App\Form\BookCollectionType;
use App\Form\BorrowType;
use App\Form\EditorType;
use App\Form\KeywordType;
use App\Form\KeywordRefType;
use App\Form\LanguageType;
use App\Form\LocalisationType;
use App\Form\PublicationTypeType;
use App\Form\SearchAdminBorrowFormType;
use App\Form\ThematicType;
use App\Form\UserType;
use App\Repository\AuthorRepository;
use App\Repository\BookCollectionRepository;
use App\Repository\BorrowRepository;
use App\Repository\EditorRepository;
use App\Repository\KeywordRepository;
use App\Repository\KeywordRefRepository;
use App\Repository\LanguageRepository;
use App\Repository\LocalisationRepository;
use App\Repository\PublicationTypeRepository;
use App\Repository\ThematicRepository;
use App\Repository\UserRepository;
use App\Service\Slugify;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(AuthorRepository $authorRepository): Response
    {
        return $this->render('admin/dashboard/panel.html.twig', [
            'authors' => $authorRepository->findAll(),
            'user' => $this->getUser()
        ]);
    }

    ///////////////////// USER /////////////////////

    /**
     * @Route("/admin/utilisateurs", name="user_list", methods={"GET"})
     */
    public function userList(UserRepository $userRepository): Response
    {
        return $this->render('/admin/user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/utilisateurs/creation", name="user_add", methods={"GET","POST"})
     */
    public function userAdd(Request $request, UserPasswordEncoderInterface $passwordEncoder, Slugify $slugify): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $fullname = $user->getFirstname().' '.$user->getLastname();
            $user->setSlug($slugify->generate($fullname));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_list');
        }

        return $this->render('/admin/user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/utilisateur/{id}", name="user_show", methods={"GET"})
     */
    public function userShow(User $user): Response
    {
        return $this->render('/admin/user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/admin/utilisateur/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function userEdit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_list');
        }

        return $this->render('/admin/user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/utilisateur/{id}", name="user_delete")
     */
    public function userDelete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_list');
    }

    ////////////////////////////////////////////////////////////////////////////////////

    ///////////////////// THEMATIC /////////////////////

    /**
     * @Route("/admin/thematic", name="thematic_list", methods={"GET"})
     */
    public function thematicList(ThematicRepository $thematicRepository): Response
    {
        return $this->render('/admin/thematic/index.html.twig', [
            'thematics' => $thematicRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/thematic/creation", name="thematic_add", methods={"GET","POST"})
     */
    public function thematicAdd(Request $request): Response
    {
        $thematic = new Thematic();
        $form = $this->createForm(ThematicType::class, $thematic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($thematic);
            $entityManager->flush();

            return $this->redirectToRoute('thematic_list');
        }

        return $this->render('/admin/thematic/new.html.twig', [
            'thematic' => $thematic,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/thematic/{id}", name="thematic_show", methods={"GET"})
     */
    public function thematicShow(Thematic $thematic): Response
    {
        return $this->render('/admin/thematic/show.html.twig', [
            'thematic' => $thematic,
        ]);
    }

    /**
     * @Route("/admin/thematic/{id}/edit", name="thematic_edit", methods={"GET","POST"})
     */
    public function thematicEdit(Request $request, Thematic $thematic): Response
    {
        $form = $this->createForm(ThematicType::class, $thematic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('thematic_list');
        }

        return $this->render('/admin/thematic/edit.html.twig', [
            'thematic' => $thematic,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/thematic/{id}", name="thematic_delete", methods={"DELETE"})
     */
    public function thematicDelete(Request $request, Thematic $thematic): Response
    {
        if ($this->isCsrfTokenValid('delete'.$thematic->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($thematic);
            $entityManager->flush();
        }

        return $this->redirectToRoute('thematic_list');
    }

    ////////////////////////////////////////////////////////////////////////////////////

    ///////////////////// LOCALISATION /////////////////////

    /**
     * @Route("/admin/localisation", name="localisation_list", methods={"GET"})
     */
    public function localisationList(LocalisationRepository $localisationRepository): Response
    {
        return $this->render('/admin/localisation/index.html.twig', [
            'localisations' => $localisationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/localisation/creation", name="localisation_add", methods={"GET","POST"})
     */
    public function localisationAdd(Request $request): Response
    {
        $localisation = new Localisation();
        $form = $this->createForm(LocalisationType::class, $localisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($localisation);
            $entityManager->flush();

            return $this->redirectToRoute('localisation_list');
        }

        return $this->render('/admin/localisation/new.html.twig', [
            'localisation' => $localisation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/localisation/{id}", name="localisation_show", methods={"GET"})
     */
    public function localisationShow(Localisation $localisation): Response
    {
        return $this->render('/admin/localisation/show.html.twig', [
            'localisation' => $localisation,
        ]);
    }

    /**
     * @Route("/admin/localisation/{id}/edit", name="localisation_edit", methods={"GET","POST"})
     */
    public function localisationEdit(Request $request, Localisation $localisation): Response
    {
        $form = $this->createForm(LocalisationType::class, $localisation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('localisation_list');
        }

        return $this->render('/admin/localisation/edit.html.twig', [
            'localisation' => $localisation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/localisation/{id}", name="localisation_delete", methods={"DELETE"})
     */
    public function localisationDelete(Request $request, Localisation $localisation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$localisation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($localisation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('localisation_list');
    }

    ////////////////////////////////////////////////////////////////////////////////////

    ////////////////////////////////KEYWORD/////////////////////////////////////////////

    /**
     * @Route("/admin/keyword", name="keyword_list", methods={"GET"})
     */
    public function keywordList(KeywordRepository $keywordRepository): Response
    {
        return $this->render('/admin/keyword/index.html.twig', [
            'keywords' => $keywordRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/keyword/creation", name="keyword_add", methods={"GET","POST"})
     */
    public function keywordAdd(Request $request): Response
    {
        $keyword = new Keyword();
        $form = $this->createForm(KeywordType::class, $keyword);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($keyword);
            $entityManager->flush();

            return $this->redirectToRoute('keyword_list');
        }

        return $this->render('/admin/keyword/new.html.twig', [
            'keyword' => $keyword,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/keyword/{id}", name="keyword_show", methods={"GET"})
     */
    public function keywordShow(Keyword $keyword): Response
    {
        return $this->render('/admin/keyword/show.html.twig', [
            'keyword' => $keyword,
        ]);
    }

    /**
     * @Route("/admin/keyword/{id}/edit", name="keyword_edit", methods={"GET","POST"})
     */
    public function keywordEdit(Request $request, Keyword $keyword): Response
    {
        $form = $this->createForm(KeywordType::class, $keyword);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('keyword_list');
        }

        return $this->render('/admin/keyword/edit.html.twig', [
            'keyword' => $keyword,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/keyword/{id}", name="keyword_delete", methods={"DELETE"})
     */
    public function keywordDelete(Request $request, Keyword $keyword): Response
    {
        if ($this->isCsrfTokenValid('delete'.$keyword->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($keyword);
            $entityManager->flush();
        }

        return $this->redirectToRoute('keyword_list');
    }

    ////////////////////////////////////////////////////////////////////////////////////

    ///////////////////////////////////////EDITOR///////////////////////////////////////

    /**
     * @Route("/admin/editor", name="editor_list", methods={"GET"})
     */
    public function editorList(EditorRepository $editorRepository): Response
    {
        return $this->render('/admin/editor/index.html.twig', [
            'editors' => $editorRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/editor/creation", name="editor_add", methods={"GET","POST"})
     */
    public function editorAdd(Request $request): Response
    {
        $editor = new Editor();
        $form = $this->createForm(EditorType::class, $editor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($editor);
            $entityManager->flush();

            return $this->redirectToRoute('editor_list');
        }

        return $this->render('/admin/editor/new.html.twig', [
            'editor' => $editor,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/editor/{id}", name="editor_show", methods={"GET"})
     */
    public function editorShow(Editor $editor): Response
    {
        return $this->render('/admin/editor/show.html.twig', [
            'editor' => $editor,
        ]);
    }

    /**
     * @Route("/admin/editor/{id}/edit", name="editor_edit", methods={"GET","POST"})
     */
    public function editorEdit(Request $request, Editor $editor): Response
    {
        $form = $this->createForm(EditorType::class, $editor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('editor_list');
        }

        return $this->render('/admin/editor/edit.html.twig', [
            'editor' => $editor,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/editor/{id}", name="editor_delete", methods={"DELETE"})
     */
    public function editorDelete(Request $request, Editor $editor): Response
    {
        if ($this->isCsrfTokenValid('delete'.$editor->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($editor);
            $entityManager->flush();
        }

        return $this->redirectToRoute('editor_list');
    }

    ////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////BOOK COLLECTION//////////////////////////////////////////

    /**
     * @Route("/admin/bookcollection", name="book_collection_list", methods={"GET"})
     */
    public function bookCollectionList(Request $request, BookCollectionRepository $bookCollectionRepository): Response
    {
        return $this->render('/admin/book_collection/index.html.twig', [
            'book_collections' => $bookCollectionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/bookcollection/creation", name="book_collection_add", methods={"GET","POST"})
     */
    public function bookCollectionAdd(Request $request): Response
    {
        $bookCollection = new BookCollection();
        $form = $this->createForm(BookCollectionType::class, $bookCollection);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($bookCollection);
            $entityManager->flush();

            return $this->redirectToRoute('book_collection_list');
        }

        return $this->render('/admin/book_collection/new.html.twig', [
            'book_collection' => $bookCollection,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/bookcollection/{id}", name="book_collection_show", methods={"GET"})
     */
    public function bookCollectionShow(BookCollection $bookCollection): Response
    {
        return $this->render('/admin/book_collection/show.html.twig', [
            'book_collection' => $bookCollection,
        ]);
    }

    /**
     * @Route("/admin/bookCollection/{id}/edit", name="book_collection_edit", methods={"GET","POST"})
     */
    public function bookCollectionEdit(Request $request, BookCollection $bookCollection): Response
    {
        $form = $this->createForm(BookCollectionType::class, $bookCollection);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('book_collection_list');
        }

        return $this->render('/admin/book_collection/edit.html.twig', [
            'book_collection' => $bookCollection,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/bookCollection/{id}", name="book_collection_delete", methods={"DELETE"})
     */
    public function bookCollectionDelete(Request $request, BookCollection $bookCollection): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bookCollection->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($bookCollection);
            $entityManager->flush();
        }

        return $this->redirectToRoute('book_collection_list');
    }

    ////////////////////////////////////////////////////////////////////////////////////

    ////////////////////////////////////PUBLICATION TYPE///////////////////////////////////////

    /**
     * @Route("/admin/publicationType", name="publication_type_list", methods={"GET"})
     */
    public function publicationTypeList(PublicationTypeRepository $publicationTypeRepository): Response
    {
        return $this->render('/admin/publication_type/index.html.twig', [
            'publication_types' => $publicationTypeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/publicationType/creation", name="publication_type_add", methods={"GET","POST"})
     */
    public function publicationTypeAdd(Request $request): Response
    {
        $publicationType = new PublicationType();
        $form = $this->createForm(PublicationTypeType::class, $publicationType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($publicationType);
            $entityManager->flush();

            return $this->redirectToRoute('publication_type_list');
        }

        return $this->render('/admin/publication_type/new.html.twig', [
            'publication_type' => $publicationType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/publicationType/{id}", name="publication_type_show", methods={"GET"})
     */
    public function publicationTypeShow(PublicationType $publicationType): Response
    {
        return $this->render('/admin/publication_type/show.html.twig', [
            'publication_type' => $publicationType,
        ]);
    }

    /**
     * @Route("/admin/publicationType/{id}/edit", name="publication_type_edit", methods={"GET","POST"})
     */
    public function publicationTypeEdit(Request $request, PublicationType $publicationType): Response
    {
        $form = $this->createForm(PublicationTypeType::class, $publicationType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('publication_type_list');
        }

        return $this->render('/admin/publication_type/edit.html.twig', [
            'publication_type' => $publicationType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/publicationType/{id}", name="publication_type_delete", methods={"DELETE"})
     */
    public function publicationTypeDelete(Request $request, PublicationType $publicationType): Response
    {
        if ($this->isCsrfTokenValid('delete'.$publicationType->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($publicationType);
            $entityManager->flush();
        }

        return $this->redirectToRoute('publication_type_list');
    }

    ////////////////////////////////////////////////////////////////////////////////////

    /////////////////////////// LANGUAGE ////////////////////////////////////

    /**
     * @Route("/admin/language", name="language_list", methods={"GET"})
     */
    public function languageList(LanguageRepository $languageRepository): Response
    {
        return $this->render('/admin/language/index.html.twig', [
            'languages' => $languageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/language/creation", name="language_add", methods={"GET","POST"})
     */
    public function languageAdd(Request $request): Response
    {
        $language = new Language();
        $form = $this->createForm(LanguageType::class, $language);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($language);
            $entityManager->flush();

            return $this->redirectToRoute('language_list');
        }

        return $this->render('/admin/language/new.html.twig', [
            'language' => $language,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/language/{id}", name="language_show", methods={"GET"})
     */
    public function languageShow(Language $language): Response
    {
        return $this->render('/admin/language/show.html.twig', [
            'language' => $language,
        ]);
    }

    /**
     * @Route("/admin/language/{id}/edit", name="language_edit", methods={"GET","POST"})
     */
    public function languageEdit(Request $request, Language $language): Response
    {
        $form = $this->createForm(LanguageType::class, $language);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('language_list');
        }

        return $this->render('/admin/language/edit.html.twig', [
            'language' => $language,
            'form' => $form->createView(),
        ]);
    }

    /**
     *  @Route("/admin/language/{id}", name="language_delete", methods={"DELETE"})
     */
    public function LanguageDelete(Request $request, Language $language): Response
    {
        if ($this->isCsrfTokenValid('delete'.$language->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($language);
            $entityManager->flush();
        }

        return $this->redirectToRoute('language_list');
    }

    //////////////////////////////////////////////////////////////////////////////////////////////

    /////////////////////EMPRUNT//START/////////////////////////////////////////////////////////

    /**
     * @Route("/admin/emprunt", name="emprunt_list", methods={"GET"})
     */
    public function borrowList(BorrowRepository $borrowRepository, Request $request): Response
    {

        $form = $this->createForm(SearchAdminBorrowFormType::class)->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){
            $search = $form->getData()['search'];
            $borrowRepository->findBy(['cote' => $search]);
        }else{
            $borrowRepository->findAll();
        }
        return $this->render('/admin/borrow/index.html.twig', [
            'borrows' => $borrowRepository->findAll(),
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/emprunt/creation", name="emprunt_add", methods={"GET","POST"})
     */
    public function borrowAdd(Request $request): Response
    {
        $borrow = new Borrow();
        $form = $this->createForm(BorrowType::class, $borrow);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($borrow);
            $entityManager->flush();

            return $this->redirectToRoute('emprunt_list');
        }

        return $this->render('/admin/borrow/new.html.twig', [
            'borrow' => $borrow,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/emprunt/{id}", name="emprunt_show", methods={"GET"})
     */
    public function borrowShow(Borrow $borrow): Response
    {
        return $this->render('/admin/borrow/show.html.twig', [
            'borrow' => $borrow,
        ]);
    }

    /**
     * @Route("/admin/emprunt/{id}/edit", name="emprunt_edit", methods={"GET","POST"})
     */
    public function borrowEdit(Request $request, Borrow $borrow): Response
    {
        $form = $this->createForm(BorrowType::class, $borrow);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('emprunt_list');
        }

        return $this->render('/admin/borrow/edit.html.twig', [
            'borrow' => $borrow,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/emprunt/{id}", name="emprunt_delete", methods={"DELETE"})
     */
    public function borrowDelete(Request $request, Borrow $borrow): Response
    {
        if ($this->isCsrfTokenValid('delete'.$borrow->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($borrow);
            $entityManager->flush();
        }

        return $this->redirectToRoute('emprunt_list');
    }

    //////////////////////////EMPRUNT END/////////////////////////////////////////////

    //////////////////////////AUTEUR START///////////////////////////////////////////////

    /**
     * @Route("/admin/auteur", name="auteur_list", methods={"GET"})
     */
    public function authorList(AuthorRepository $authorRepository): Response
    {
        return $this->render('/admin/author/index.html.twig', [
            'authors' => $authorRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/auteur/creation", name="auteur_add", methods={"GET","POST"})
     */
    public function authorAdd(Request $request): Response
    {
        $author = new Author();
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($author);
            $entityManager->flush();

            return $this->redirectToRoute('auteur_list');
        }

        return $this->render('/admin/author/new.html.twig', [
            'author' => $author,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/auteur/{id}", name="auteur_show", methods={"GET"})
     */
    public function authorShow(Author $author): Response
    {
        return $this->render('/admin/author/show.html.twig', [
            'author' => $author,
        ]);
    }

    /**
     * @Route("/admin/auteur/{id}/edit", name="auteur_edit", methods={"GET","POST"})
     */
    public function authorEdit(Request $request, Author $author): Response
    {
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('auteur_list');
        }

        return $this->render('/admin/author/edit.html.twig', [
            'author' => $author,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/auteur/{id}", name="auteur_delete", methods={"DELETE"})
     */
    public function authorDelete(Request $request, Author $author): Response
    {
        if ($this->isCsrfTokenValid('delete'.$author->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($author);
            $entityManager->flush();
        }

        return $this->redirectToRoute('auteur_list');
    }

    //////////////////////////////KEYWORD REF START/////////////////////////////////

 /**
     * @Route("/admin/keyword_ref", name="keyword_ref_list", methods={"GET"})
     */
    public function keywordRefList(KeywordRefRepository $keywordRefRepository): Response
    {
        return $this->render('/admin/keyword_ref/index.html.twig', [
            'keyword_refs' => $keywordRefRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/keyword_ref/creation", name="keyword_ref_add", methods={"GET","POST"})
     */
    public function keywordRefAdd(Request $request): Response
    {
        $keywordRef = new KeywordRef();
        $form = $this->createForm(KeywordRefType::class, $keywordRef);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($keywordRef);
            $entityManager->flush();

            return $this->redirectToRoute('keyword_ref_list');
        }

        return $this->render('/admin/keyword_ref/new.html.twig', [
            'keyword_ref' => $keywordRef,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/keyword_ref/{id}", name="keyword_ref_show", methods={"GET"})
     */
    public function keywordRefShow(KeywordRef $keywordRef): Response
    {
        return $this->render('/admin/keyword_ref/show.html.twig', [
            'keyword_ref' => $keywordRef,
        ]);
    }

    /**
     * @Route("/admin/keyword_ref/{id}/edit", name="keyword_ref_edit", methods={"GET","POST"})
     */
    public function keywordRefEdit(Request $request, KeywordRef $keywordRef): Response
    {
        $form = $this->createForm(KeywordRefType::class, $keywordRef);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('keyword_ref_list');
        }

        return $this->render('/admin/keyword_ref/edit.html.twig', [
            'keyword_ref' => $keywordRef,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/keyword_ref/{id}", name="keyword_ref_delete", methods={"POST"})
     */
    public function keywordRefDelete(Request $request, KeywordRef $keywordRef): Response
    {
        if ($this->isCsrfTokenValid('delete'.$keywordRef->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($keywordRef);
            $entityManager->flush();
        }

        return $this->redirectToRoute('keyword_ref_list');
    }

  //////////////////////////////KEYWORD REF END/////////////////////////////////
  ////////////////////////////////////////////////////////////////////////////////

}
