<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class GameVoter extends Voter
{
    /**
     * Indique si ce voter est concerné par l'action (attribute) et l'entité (subject)
     */
    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['EDIT', 'VIEW'])
            && $subject instanceof \App\Entity\Game;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return 'VIEW' === $attribute && $subject->getEnabled();
        }

        // Si admin on retourne true pour toute action
        if (in_array('ROLE_ADMIN', $user->getRoles())) {
            return true;
        }
        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case 'EDIT':
                // logic to determine if the user can EDIT
                // return true or false
                return $subject->getUser() == $user;
                break;
            case 'VIEW':
                // logic to determine if the user can VIEW
                // return true or false
                return $subject->getEnabled() || $subject->getUser() == $user;
                break;
        }

        return false;
    }
}
