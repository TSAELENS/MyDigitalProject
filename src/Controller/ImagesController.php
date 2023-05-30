<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Images;
use Symfony\Component\Routing\Annotation\Route;

class ImagesController extends AbstractController
{
    #[Route('/images/upload', name: 'app_images_upload')]
    public function upload()
    {
        return $this->render('images/index.html.twig', [
            'controller_name' => 'ImagesController'
        ]);
    }
    // public function likeImage(Request $request, Images $image)
    // {
    //     // Récupérez l'utilisateur actuellement connecté (utilisez $this->getUser() si vous utilisez le composant de sécurité Symfony)
    //     $user = $this->getUser();

    //     // Vérifiez si l'utilisateur existe et s'il n'a pas déjà aimé l'image
    //     if ($user && !$image->getFavoris()->contains($user)) {
    //         // Ajoutez l'utilisateur à la collection de favoris de l'image
    //         $image->addFavori($user);

    //         // Mettez à jour l'entité dans la base de données
    //         $entityManager = $this->getDoctrine()->getManager();
    //         $entityManager->flush();
    //     }

    //     // Retournez une réponse JSON indiquant le nombre total de likes de l'image après l'action
    //     return new JsonResponse(['likes' => $image->getFavoris()->count()]);
    // }
}
