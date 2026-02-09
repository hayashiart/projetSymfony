<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin_dashboard')]
    #[IsGranted('ROLE_ADMIN')]
    public function dashboard(EventRepository $eventRepository, UserRepository $userRepository): Response
    {
        $events = $eventRepository->findAll();
        $users = $userRepository->findAll();

        return $this->render('admin/dashboard.html.twig', [
            'totalEvents' => count($events),
            'totalUsers' => count($users),
            'events' => $events,
        ]);
    }
}