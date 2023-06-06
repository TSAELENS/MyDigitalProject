<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UsersRepository;
use Symfony\Bundle\SecurityBundle\Security;

class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'profil')]
    public function showProfil(Security $security): Response
    {
        $user = $security->getUser();

        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non connecté.');
        }

        return $this->render('profil/profil.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/tattler', name: 'tattler')]
    public function index(UsersRepository $usersRepository): Response
    {
        $profils = $usersRepository->createQueryBuilder('u')
            ->where('u.roles LIKE :role')
            ->setParameter('role', '%ROLE_TATTLER%')
            ->getQuery()
            ->getResult();

        $tatoueurs = [];

        foreach ($profils as $profil) {
            if (in_array('ROLE_TATTLER', $profil->getRoles())) {
                $tatoueurs[] = $profil;
            }
        }

        return $this->render('profil/index.html.twig', [
            'tatoueurs' => $tatoueurs,
        ]);
    }
}
