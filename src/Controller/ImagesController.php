<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Images;
use App\Form\ImageUploadType;
use App\Repository\ImagesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ImagesController extends AbstractController
{
    #[Route('/creation', name: 'app_images_upload')]
    public function upload(Request $request, EntityManagerInterface $entityManager)
    {
        $image = new Images();

        $uploadDirectory = 'upload/img/';

        $form = $this->createForm(ImageUploadType::class, $image, [
                'upload_directory' => $uploadDirectory,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($image);
            $entityManager->flush();
        }

        return $this->render('images/upload.html.twig', [
            'uploadForm' => $form->createView(),
            'upload_directory' => 'upload/img/',
        ]);
    }
}
