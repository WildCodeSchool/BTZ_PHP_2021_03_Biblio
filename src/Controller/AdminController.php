<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/dashboard", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin/testContent.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
}
