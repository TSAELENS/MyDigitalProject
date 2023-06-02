<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoriesRepository;

class DiscoverController extends AbstractController
{
    #[Route('/discover', name: 'app_discover')]
    public function categories(CategoriesRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render('discover/categories.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/discover/{id}", name="discover_gallery")
     */
    public function gallery($id, CategoriesRepository $categoryRepository): Response
    {
        $categorie = $categoryRepository->find($id);

        if (!$categorie) {
            throw $this->createNotFoundException('Catégorie non trouvée');
        }

        return $this->render('discover/gallery.html.twig', [
            'categorie' => $categorie,
        ]);
    }
}
