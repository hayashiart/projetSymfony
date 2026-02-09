<?php

namespace App\Security\Voter;

use App\Entity\Event;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class EventOwnerVoter extends Voter
{
    public const EDIT   = 'EVENT_EDIT';
    public const DELETE = 'EVENT_DELETE';

    public function __construct(private readonly AuthorizationCheckerInterface $authChecker)
    {
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        // ce voter ne gère que les actions sur Event + les attributs qu'on définit
        return in_array($attribute, [self::EDIT, self::DELETE])
            && $subject instanceof Event;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        // si pas connecté → non
        if (!$user instanceof UserInterface) {
            return false;
        }

        // Admin peut tout faire
        if ($this->authChecker->isGranted('ROLE_ADMIN')) {
            return true;
        }

        // Pour les users normaux → doit être l'organisateur
        /** @var Event $event */
        $event = $subject;

        return $event->getOrganizer() === $user;
    }
}