<?php

namespace App\Controller;

use App\Repository\PublicationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     *
     * @param mixed $publicationRepository
     */
    public function index(PublicationRepository $publicationRepository): Response
    {
        $user = $this->getUser();

        $lastPublications = $publicationRepository->findBy([], ['publication_date' => 'DESC'], 3);

        return $this->render('home/index.html.twig', [
            'user' => $this->getUser(),
            'publications' => $lastPublications,
        ]);
    }

    /**
     * @Route("/autocomplete", name="autocomplete", methods={"GET"})
     */
    public function autocomplete(Request $request, PublicationRepository $publicationRepository): Response
    {
        $query = $request->query->get('q');
        if (null !== $query) {
            $keywords = explode(' ', $query);
            $publications = [];
            foreach ($keywords as $keyword) {
                $publications = array_merge($publications, $publicationRepository->findByQueryAuto($keyword));
            }
            // $publications = $publicationRepository->findByQueryAuto($query);
        }
        $publications = array_slice($publications, 0, 10);

        return $this->json($publications, 200);
    }
}
