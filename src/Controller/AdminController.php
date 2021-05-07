<?php

namespace App\Controller;

use App\Entity\Editor;
use App\Entity\Keyword;
use App\Entity\User;
use App\Form\EditorType;
use App\Form\KeywordType;
use App\Form\UserType;
use App\Repository\AuthorRepository;
use App\Repository\EditorRepository;
use App\Repository\KeywordRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(AuthorRepository $authorRepository): Response
    {
        return $this->render('admin/dashboard/panel.html.twig', [
            'authors' => $authorRepository->findAll(),
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
    public function userAdd(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
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
     * @Route("/{id}", name="keyword_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Keyword $keyword): Response
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
        var_dump('ts');
        if ($this->isCsrfTokenValid('delete'.$editor->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($editor);
            $entityManager->flush();
        }

        return $this->redirectToRoute('editor_list');
    }

    ////////////////////////////////////////////////////////////////////////////////////
}
