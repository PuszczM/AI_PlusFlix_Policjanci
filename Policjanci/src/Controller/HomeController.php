<?php

namespace App\Controller;

use App\Service\Database;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request; // <--- WAŻNE: Dodaj to!
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request, Database $db): Response
    {

        $searchTerm = $request->query->get('q');
        $movies = [];

        if ($searchTerm) {

            $sql = "SELECT * FROM movies WHERE title LIKE ? LIMIT 20";
            $movies = $db->query($sql, ['%' . $searchTerm . '%']);
        } else {
            $movies = $db->query("SELECT * FROM movies LIMIT 10");
        }

        return $this->render('home/index.html.twig', [
            'movies' => $movies,
            'searchTerm' => $searchTerm,
        ]);
    }
}
