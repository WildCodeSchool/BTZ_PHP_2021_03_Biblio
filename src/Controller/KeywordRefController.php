<?php

namespace App\Controller;

use App\Entity\KeywordRef;
use App\Form\KeywordRefType;
use App\Repository\KeywordRefRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/keyword/ref")
 */
class KeywordRefController extends AbstractController
{
    /**
     * @Route("/", name="keyword_ref_index", methods={"GET"})
     */
    public function index(KeywordRefRepository $keywordRefRepository): Response
    {
        return $this->render('keyword_ref/index.html.twig', [
            'keyword_refs' => $keywordRefRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="keyword_ref_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $keywordRef = new KeywordRef();
        $form = $this->createForm(KeywordRefType::class, $keywordRef);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($keywordRef);
            $entityManager->flush();

            return $this->redirectToRoute('keyword_ref_index');
        }

        return $this->render('keyword_ref/new.html.twig', [
            'keyword_ref' => $keywordRef,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="keyword_ref_show", methods={"GET"})
     */
    public function show(KeywordRef $keywordRef): Response
    {
        return $this->render('keyword_ref/show.html.twig', [
            'keyword_ref' => $keywordRef,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="keyword_ref_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, KeywordRef $keywordRef): Response
    {
        $form = $this->createForm(KeywordRefType::class, $keywordRef);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('keyword_ref_index');
        }

        return $this->render('keyword_ref/edit.html.twig', [
            'keyword_ref' => $keywordRef,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="keyword_ref_delete", methods={"POST"})
     */
    public function delete(Request $request, KeywordRef $keywordRef): Response
    {
        if ($this->isCsrfTokenValid('delete'.$keywordRef->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($keywordRef);
            $entityManager->flush();
        }

        return $this->redirectToRoute('keyword_ref_index');
    }
}
