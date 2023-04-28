<?php

namespace App\Controller;

use App\Repository\ImagesRepository;
use App\Service\SearchService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    #[Route('/', name: 'app_home')]
    public function index(Request $request, ImagesRepository $imagesRepository): Response
    {
        $searchTerm = $request->query->get('q');

        if ($searchTerm) {
            $images = $this->searchService->searchImages($searchTerm);
        } else {
            $images = $imagesRepository->findAll();
        }

        $data = [];

        foreach ($images as $image) {
            $data[] = [
                'name' => $image->getName(),
                'image' => $image->getImage(),
                'users' => $image->getCreations()->toArray(),
            ];
        }

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'data' => $data,
            'searchTerm' => $searchTerm,
        ]);
    }
}
