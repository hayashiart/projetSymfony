<?php

namespace App\DataFixtures;

use App\Entity\Event;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Créer l'admin
        $admin = new User();
        $admin->setEmail('admin@agenda.fr');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword(
            $this->passwordHasher->hashPassword($admin, 'admin123')
        );
        $manager->persist($admin);

        // Créer un utilisateur normal
        $user = new User();
        $user->setEmail('user@agenda.fr');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword(
            $this->passwordHasher->hashPassword($user, 'user123')
        );
        $manager->persist($user);

        // Événements de l'admin
        $eventsAdmin = [
            ['Concert Rock 2026', 'Grand concert au Zénith', '2026-03-15 20:00:00', '2026-03-15 23:00:00', 'Zénith Paris'],
            ['Festival Cinéma', 'Projection de films indépendants', '2026-04-05 18:00:00', '2026-04-05 22:00:00', 'Cinéma Le Grand Rex'],
        ];

        foreach ($eventsAdmin as $data) {
            $event = new Event();
            $event->setTitle($data[0]);
            $event->setDescription($data[1]);
            $event->setStartDate(new \DateTime($data[2]));
            $event->setEndDate(new \DateTime($data[3]));
            $event->setLocation($data[4]);
            $event->setCreatedAt(new \DateTime());
            $event->setOrganizer($admin);
            $manager->persist($event);
        }

        // Événements du user normal
        $eventsUser = [
            ['Randonnée en forêt', 'Balade nature et pique-nique', '2026-05-10 09:00:00', '2026-05-10 16:00:00', 'Forêt de Fontainebleau'],
            ['Soirée jeux de société', 'Tournoi de jeux de plateau', '2026-06-20 19:00:00', '2026-06-20 23:00:00', 'Café Ludique Paris'],
        ];

        foreach ($eventsUser as $data) {
            $event = new Event();
            $event->setTitle($data[0]);
            $event->setDescription($data[1]);
            $event->setStartDate(new \DateTime($data[2]));
            $event->setEndDate(new \DateTime($data[3]));
            $event->setLocation($data[4]);
            $event->setCreatedAt(new \DateTime());
            $event->setOrganizer($user);
            $manager->persist($event);
        }

        $manager->flush();
    }
}