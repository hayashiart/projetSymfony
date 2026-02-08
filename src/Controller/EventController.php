<?php

namespace App\Controller;

use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Form\EventType;
use App\Entity\Event;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class EventController extends AbstractController
{
    #[Route('/evenements', name: 'app_event_index')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function index(EventRepository $eventRepository): Response
    {
        $events = $eventRepository->findAll();

        return $this->render('event/index.html.twig', [
            'events' => $events,
        ]);
    }

    #[Route('/evenements/nouveau', name: 'app_event_new', methods: ['GET', 'POST'])]
#[IsGranted('ROLE_USER')]   // ← seulement les connectés peuvent créer
public function new(Request $request, EntityManagerInterface $entityManager): Response
{
    $event = new Event();
    $event->setOrganizer($this->getUser());  // ← l'utilisateur connecté est l'organisateur

    $form = $this->createForm(EventType::class, $event);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $event->setCreatedAt(new \DateTime());
        $entityManager->persist($event);
        $entityManager->flush();

        $this->addFlash('success', 'Événement créé avec succès !');

        return $this->redirectToRoute('app_event_index');
    }

    return $this->render('event/new.html.twig', [
        'form' => $form->createView(),
    ]);
}

#[Route('/evenements/{id}/modifier', name: 'app_event_edit', methods: ['GET', 'POST'])]
#[IsGranted('ROLE_USER')]
public function edit(Request $request, Event $event, EntityManagerInterface $entityManager): Response
{
    if ($event->getOrganizer() !== $this->getUser()) {
    throw $this->createAccessDeniedException('Vous n\'êtes pas l\'organisateur de cet événement.');
}

    $form = $this->createForm(EventType::class, $event);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->flush();

        $this->addFlash('success', 'Événement modifié avec succès !');

        return $this->redirectToRoute('app_event_index');
    }

    return $this->render('event/edit.html.twig', [
        'event' => $event,
        'form' => $form->createView(),
    ]);
}

#[Route('/evenements/{id}', name: 'app_event_delete', methods: ['POST'])]
#[IsGranted('ROLE_USER')]
public function delete(Request $request, Event $event, EntityManagerInterface $entityManager): Response
{
    // Sécurité : seul l'organisateur peut supprimer
    if ($event->getOrganizer() !== $this->getUser()) {
        throw $this->createAccessDeniedException('Vous n\'êtes pas l\'organisateur de cet événement.');
    }

    if ($this->isCsrfTokenValid('delete' . $event->getId(), $request->request->get('_token'))) {
        $entityManager->remove($event);
        $entityManager->flush();

        $this->addFlash('success', 'Événement supprimé avec succès !');
    }

    return $this->redirectToRoute('app_event_index');
}

#[Route('/mes-evenements', name: 'app_event_my')]
#[IsGranted('ROLE_USER')]
public function myEvents(EventRepository $eventRepository): Response
{
    $events = $eventRepository->findBy(
        ['organizer' => $this->getUser()],
        ['startDate' => 'ASC'] // tri par date croissante
    );

    return $this->render('event/my.html.twig', [
        'events' => $events,
    ]);
}


}