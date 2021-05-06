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
<<<<<<< HEAD
        return $this->render('admin/panel.html.twig', [
=======

        return $this->render('admin/dashboard/panel.html.twig', [
>>>>>>> 23f2af0ec00f29394a423f82a19da78036a70d92
=======

        return $this->render('admin/dashboard/panel.html.twig', [
>>>>>>> e75419a5a32bfa624a53650a2cf6784a2f4079a0
            'controller_name' => 'AdminController',
            'authors' => $authorRepository->findAll(),
        ]);
    }
}
