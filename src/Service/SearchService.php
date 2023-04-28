<?php
// src/Service/SearchService.php

namespace App\Service;

use App\Repository\ImagesRepository;

class SearchService
{
    private $imagesRepository;

    public function __construct(ImagesRepository $imagesRepository)
    {
        $this->imagesRepository = $imagesRepository;
    }

    public function searchImages(string $searchTerm): array
    {
        // Ajoutez ici votre propre code pour traiter la requête de recherche
        $images = $this->imagesRepository->findByName($searchTerm);

        return $images;
    }
}
