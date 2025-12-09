<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ManageMoviesController extends AbstractController
{
    #[Route('/admin/movies', name: 'admin_manage_movies')]
    public function index(): Response
    {
        return $this->render('admin/manage-movies.html.twig', [

        ]);
    }
}
