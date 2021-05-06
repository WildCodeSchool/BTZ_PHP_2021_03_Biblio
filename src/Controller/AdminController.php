<?php

namespace App\Controller;

use App\Repository\AuthorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/dashboard", name="admin")
     */
    public function index(AuthorRepository $authorRepository): Response
    {
<<<<<<< HEAD
        return $this->render('admin/panel.html.twig', [
=======

        return $this->render('admin/dashboard/panel.html.twig', [
>>>>>>> 23f2af0ec00f29394a423f82a19da78036a70d92
            'controller_name' => 'AdminController',
            'authors' => $authorRepository->findAll(),
        ]);
    }
}
