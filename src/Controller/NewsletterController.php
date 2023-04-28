<?php

namespace App\Controller;

use App\Entity\Newsletter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewsletterController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/newsletter/subscribe', name: 'newsletter_subscribe', methods: ['POST'])]
    public function subscribe(Request $request): Response
    {
        $email = $request->request->get('email');

        // Validation de l'email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->addFlash('error', 'L\'adresse e-mail est invalide.');
            return $this->redirectToRoute('app_home');
        }

        // Vérifie si l'utilisateur est déjà inscrit
        $existingSubscriber = $this->entityManager->getRepository(Newsletter::class)->findOneBy(['email' => $email]);
        if ($existingSubscriber) {
            $this->addFlash('warning', 'Vous êtes déjà inscrit à la newsletter.');
            return $this->redirectToRoute('app_home');
        }

        // Enregistrement du nouvel inscrit en base de données
        $subscriber = new Newsletter();
        $subscriber->setEmail($email);
        $this->entityManager->persist($subscriber);
        $this->entityManager->flush();

        $this->addFlash('success', 'Merci de vous être inscrit à notre newsletter !');

        return $this->redirectToRoute('app_home');
    }
}