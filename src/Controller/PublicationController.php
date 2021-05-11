<?php

namespace App\Controller;

use App\Entity\Publication;
use App\Entity\Author;
use App\Entity\Notice;
use App\Form\PublicationType;
use App\Form\SearchPublicationFormType;
use App\Repository\NoticeRepository;
use App\Repository\PublicationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/publication")
 */
class PublicationController extends AbstractController
{
    /**
     * @Route("/", name="publication_index", methods={"GET"})
     */
    public function index(PublicationRepository $publicationRepository): Response
    {
        return $this->render('publication/index.html.twig', [
            'publications' => $publicationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/list", name="publication_list")
     */
    public function list(Request $request, PublicationRepository $publicationRepository): Response
    {
        $form = $this->createForm(SearchPublicationFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $typeSearch = $form->getData() ['type_search'];
            $thematicSearch = $form->getData() ['thematic_search'];
            $authorSearch = $form->getData() ['author_search'];
            $keywordSearch = $form->getData() ['keyword_search'];
            $keywordGeoSearch = $form->getData() ['keywordGeo_search'];
            $borrowerSearch = $form->getData() ['borrower_search'];
            $dateStartSearch = $form->getData() ['dateStart_search'];
            $dateEndSearch = $form->getData() ['dateEnd_search'];
            
            $tabSearch = [];
            foreach ($_POST['search_publication_form'] as $key => $value) {
                if (!empty($value) && $key !== '_token' && $value !== null) {
                    if ($key === 'keyword_search' || $key === 'author_search') {
                        $tabSearch[$key] = $form->getData() [$key]->getName();
                    } else {
                        $tabSearch[$key] = $form->getData() [$key];
                    }
                }
            };
            // dd($tabSearch);
            $publications = $publicationRepository->findByCriteria($tabSearch);
        // $publications = $publicationRepository->findByCriteria([
            //     'type' => $typeSearch,
            //     'thematic' => $thematicSearch,
            //     'author' => $authorSearch->getName(),
            //     'keyword' => $keywordSearch,
            //     'dateStart' => $dateStartSearch,
            //     'dateEnd' => $dateEndSearch,
            //     ]);
        } else {
            $publications = $publicationRepository->findAll();
        }
        
        return $this->render('publication/listpublic.html.twig', [
            'publications' => $publications,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new", name="publication_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $publication = new Publication();
        $form = $this->createForm(PublicationType::class, $publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($publication);
            $entityManager->flush();

            return $this->redirectToRoute('publication_index');
        }

        return $this->render('publication/new.html.twig', [
            'publication' => $publication,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="publication_show", methods={"GET"})
     */
    public function show(Publication $publication): Response
    {
        return $this->render('publication/showPub.html.twig', [
            'publication' => $publication,
        ]);
    }

    /**
     * @Route("/pub{id}", name="publication_showpub", methods={"GET"})
     */
    public function showPub(Publication $publication): Response
    {
        return $this->render('publication/showPub.html.twig', [
            'publication' => $publication,
        ]);
    }
    /**
     * @Route("/{id}/edit", name="publication_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Publication $publication, NoticeRepository $noticeRepository): Response
    {
        $form = $this->createForm(PublicationType::class, $publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('publication_index');
        }
        
        return $this->render('publication/edit.html.twig', [
            'publication' => $publication,
            'notices' => $noticeRepository->findBy(['publication' => $publication]),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="publication_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Publication $publication): Response
    {
        if ($this->isCsrfTokenValid('delete'.$publication->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($publication);
            $entityManager->flush();
        }

        return $this->redirectToRoute('publication_index');
    }
}
