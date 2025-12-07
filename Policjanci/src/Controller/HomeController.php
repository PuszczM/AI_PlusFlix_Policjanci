<?php

namespace App\Controller;


use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(Request $request, MovieRepository $movieRepository): Response
    {
        $searchTerm = $request->query->get('q');
        $movies = [];
        if($searchTerm){
            $queryBuilder = $movieRepository->createQueryBuilder('m')
                ->where('m.title LIKE :term')
                ->setParameter('term', '%' . $searchTerm . '%')
                ->setMaxResults(20)
                ->getQuery();
            $movies = $queryBuilder->getResult();
        }else{
            $movies = $movieRepository->findBy([], null, 10);
        }

        return $this->render('home/index.html.twig', [
            'movies' => $movies,
            'searchTerm' => $searchTerm,
        ]);
    }
}
