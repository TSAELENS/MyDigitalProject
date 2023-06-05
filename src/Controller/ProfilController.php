<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UsersRepository;
use ReflectionMethod;
use Symfony\Component\PropertyAccess\PropertyAccess;

class ProfilController extends AbstractController
{
    #[Route('/tatoueurs', name: 'tatoueurs')]
    public function index(UsersRepository $usersRepository): Response
    {
        $profils = $usersRepository->createQueryBuilder('u')
            ->where('u.roles LIKE :role')
            ->setParameter('role', '%ROLE_TATTLER%')
            ->getQuery()
            ->getResult();
        
        $accessor = PropertyAccess::createPropertyAccessor();
        $tatoueurs = [];

        foreach ($profils as $profil) {
            if (in_array('ROLE_TATTLER', $profil->getRoles())) {
                $tatoueur = new \stdClass();
                $tatoueur->last_name = $this->callPrivateMethod($profil, 'getLastName');
                $tatoueur->first_name = $this->callPrivateMethod($profil, 'getFirstName');
                $tatoueur->city = $this->callPrivateMethod($profil, 'getCity');
                $tatoueurs[] = $tatoueur;
            }
        }

        return $this->render('profil/index.html.twig', [
            'tatoueurs' => $tatoueurs,
        ]);
    }

    private function callPrivateMethod($object, $methodName)
    {
        $reflectionMethod = new ReflectionMethod(get_class($object), $methodName);
        $reflectionMethod->setAccessible(true);
        return $reflectionMethod->invoke($object);
    }

}
