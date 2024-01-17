<?php

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class GameVoter extends Voter
{
    public const EDIT = 'POST_EDIT';
    public const VIEW = 'POST_VIEW';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::VIEW])
            && $subject instanceof \App\Entity\Game;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if ($user instanceof User && $user->hasRole('ROLE_ADMIN')) {
            return true;
        }

        if ($attribute === self::VIEW) {
<<<<<<< HEAD
            return $subject->isPublished() || $user === $subject->getAuthor(); // On peut voir le jeu seulement s'il est publié
        }

        if ($attribute === self::EDIT) {
            return $user === $subject->getAuthor();
=======
            return $subject->isPublished() || $subject->getAuthor() === $user; // On peut voir la fiche du jeu
        }

        if ($attribute === self::EDIT) {
            return $subject->getAuthor() === $user;
>>>>>>> TP3
        }

        return false;
    }
}
