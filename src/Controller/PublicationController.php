<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Borrow;
use App\Entity\Publication;
use App\Form\PublicationType;
use App\Form\BorrowType;
use App\Form\SearchPublicationFormType;
use App\Repository\PublicationRepository;
use DateTime;
use Doctrine\ORM\EntityManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime as ConstraintsDateTime;

/**
 * @Route("/publication")
 */
class PublicationController extends AbstractController
{
    /**
     * @Route("/", name="publication_index", methods={"GET"})
     */
    public function index(PublicationRepository $publicationRepository, Request $request): Response
    {
        $query = $request->query->get('q');

        if (null !== $query) {
            $publications = $publicationRepository->findByQuery($query);
        } else {
            $publications = $publicationRepository->findAll();
        }

        return $this->render('publication/index.html.twig', [
            'publications' => $publications,
        ]);
    }

    /**
     * @Route("/list", name="publication_list")
     */
    public function list(Request $request, PublicationRepository $publicationRepository, PaginatorInterface $paginator, SessionInterface $session): Response
    {
        $form = $this->createForm(SearchPublicationFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fieldsSearch = $form->getData();
            $typeSearch = $form->getData()['type_search'];
            $thematicSearch = $form->getData()['thematic_search'];
            $authorSearch = $form->getData()['author_search'];
            $keywordRefSearch = $form->getData()['keywordRef_search'];
            $keywordGeoSearch = $form->getData()['keywordGeo_search'];
            if ($this->isGranted('ROLE_AUDAP_MEMBER')) {
                $borrowSearch = $form->getData()['borrow_search'];
                $coteSearch = $form->getData()['cote_search'];
            }
            $dateStartSearch = $form->getData()['dateStart_search'];
            $dateEndSearch = $form->getData()['dateEnd_search'];
            // $em = $this->getDoctrine()->getManager();
            // $em->persist($typeSearch);
            // $em->persist($thematicSearch);
            // $em->flush();

            $tabSearch = [];
            foreach ($_POST['search_publication_form'] as $key => $value) {
                if (!empty($value) && '_token' !== $key && null !== $value) {
                    if ('keywordRef_search' === $key || 'keywordGeo_search' === $key || 'author_search' === $key) {
                        $tabSearch[$key] = $form->getData()[$key]->getName();
                    } elseif ('borrow_search' === $key) {
                        $tabSearch[$key] = $form->getData()[$key]->getId();
                    } else {
                        $tabSearch[$key] = $form->getData()[$key];
                    }
                }
            }
            // sauvegarde du tableau de recherche pour ne pas la perdre dans le selecteur de pagination
            $session->set('search_pub', $tabSearch);
            $publications = $publicationRepository->findByCriteria($tabSearch);
        } else {
            if ($session->has('search_pub')) {
                $publications = $publicationRepository->findByCriteria($session->get('search_pub'));
            } else {
                $publications = $publicationRepository->findAll();
            }
        }

        $pagination = $paginator->paginate(
            $publications, // query NOT result
            $request->query->getInt('page', 1), // page number
            10 // limit per page
        );

        return $this->render('publication/listpublic.html.twig', [
            // 'publications' => $publications,
            'pagination' => $pagination,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/ajouter", name="publication_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $publication = new Publication();
        $form = $this->createForm(PublicationType::class, $publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
             $publication->setUser($this->getUser());
             $publication->setPublicationDate(new DateTime('now'));
             $publication->setUpdateDate(new DateTime('now'));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($publication);
            $entityManager->flush();
            dd($publication);



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
        return $this->render('publication/show.html.twig', [
            'publication' => $publication,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="publication_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Publication $publication): Response
    {
        $form = $this->createForm(PublicationType::class, $publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('publication_list');
        }

        return $this->render('publication/edit.html.twig', [
            'publication' => $publication,
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

    /**
     * @Route("/{id}/emprunt", name="publication_borrow", methods={"GET","POST"})
     */
    public function borrow(Request $request, Publication $publication, MailerInterface $mailer): Response
    {
        if ($this->getUser() !== null) {
            $borrow = new Borrow();
            $borrow->setReservationDate(new DateTime());
            $borrow->setPublication($publication);
            $borrow->setUser($this->getUser());
            $form = $this->createFormBuilder($borrow)
                // ->setAction($this->generateUrl('publication_borrow', array('id' => $publication->getId())))
                ->add('reservation_date', DateType::class, ['label' =>  'Date de réservation',])
                ->add('comment', TextType::class, ['label' =>  'Commentaire',])
                ->getForm();
            
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($borrow);
                $entityManager->flush();
                $email = (new Email())
                ->from($this->getUser()->getEmail())
                ->to($this->getParameter('mailer_to'))
                ->subject('Demande d\'emprunt pour la publication ' . $publication->getTitle())
                ->html($this->renderView(
                    'publication/borrowEmail.html.twig',
                    ['publication' => $publication,
                ]
                ));

                $mailer->send($email);
                $this->addFlash('notice', 'Votre demande d\'emprunt a bien été envoyée !');
                return $this->redirectToRoute('publication_show', [ 'id' => $publication->getId()]);
            }

            return $this->render('publication/borrow.html.twig', [
            'borrow' => $borrow,
            'publication' => $publication,
            'form' => $form->createView(),
            ]);
        } else {
            return $this->redirectToRoute('app_login');
        }
    }
}
