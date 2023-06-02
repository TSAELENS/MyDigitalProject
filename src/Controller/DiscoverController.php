<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Categories;


class DiscoverController extends AbstractController
{
        /**
     * @Route("/decouvrir", name="discover_categories")
     */
    public function categories(): Response
    {
        $categories = $this->getDoctrine()->getRepository(Categories::class)->findAll();

        return $this->render('discover/categories.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/decouvrir/{id}", name="discover_gallery")
     */
    public function gallery($id): Response
    {
        $categorie = $this->getDoctrine()->getRepository(Categories::class)->find($id);

        if (!$categorie) {
            throw $this->createNotFoundException('Catégorie non trouvée');
        }

        return $this->render('discover/gallery.html.twig', [
            'categorie' => $categorie,
        ]);
    }
}
