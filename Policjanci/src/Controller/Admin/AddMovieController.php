<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddMovieController extends AbstractController
{
    #[Route('/admin/movies/add', name: 'admin_add_movie')]
    public function index(): Response
    {
        return $this->render('admin/add-movie.html.twig', [

        ]);
    }
}
