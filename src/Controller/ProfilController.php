<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UsersRepository;


class ProfilController extends AbstractController
{
    #[Route('/profils', name: 'profils')]
    public function index(UsersRepository $usersRepository): Response
    {
        $profils = $usersRepository->findBy(['roles' => 'ROLE_TATTLER']);
        
        $tatoueurs = [];
        foreach ($profils as $profil) {
            if (in_array('ROLE_TATTLER', $profil->getRoles())) {
                $tatoueurs[] = $profil;
            }
        }

        return $this->render('profil/index.html.twig', [
            'profils' => $tatoueurs,
        ]);
    }

}
