<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Entity\Thematic;
use App\Form\ThematicType;
use App\Entity\Localisation;
use App\Repository\UserRepository;
use App\Repository\AuthorRepository;
use App\Repository\ThematicRepository;
use App\Repository\LocalisationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


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
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
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
     * @Route("/{id}", name="thematic_delete", methods={"DELETE"})
     */
    public function thematicDelete(Request $request, Thematic $thematic): Response
    {
        if ($this->isCsrfTokenValid('delete' . $thematic->getId(), $request->request->get('_token'))) {
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
    public function show(Localisation $localisation): Response
    {
        return $this->render('/admin/localisation/show.html.twig', [
            'localisation' => $localisation,
        ]);
    }

    /**
     * @Route("/admin/localisation/{id}/edit", name="localisation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Localisation $localisation): Response
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
     * @Route("/{id}", name="localisation_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Localisation $localisation): Response
    {
        if ($this->isCsrfTokenValid('delete' . $localisation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($localisation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('localisation_list');
    }



    ////////////////////////////////////////////////////////////////////////////////////


}