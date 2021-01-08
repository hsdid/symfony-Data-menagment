<?php

namespace App\Security\Voter;

use App\Entity\User;
use App\Entity\Product;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class AuthorVoter extends Voter 
{


    const EDIT   = 'edit';
    const DELETE = 'delete';

    protected function supports($attribute, $subject) 
    {

        if (! in_array($attribute, [self::EDIT, self::DELETE])) {
            return false;
        }

        if (! $subject instanceof Product) {
            return false;
        }

        return true;
    }

        
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token) 
    {
        $user = $token->getUser();

        if (!$user instanceof User ) {
            return false;
        }

        $product = $subject;


        switch ($attribute) {
            case self::DELETE:
                return $this->canDelete($product, $user);
            case self::EDIT:
                return $this->canEdit($product, $user);
        }

        

    }

    private function canEdit(Product $product, User $user)
    {
        return $user === $product->getUser();
    }

    private function canDelete(Product $product, User $user)
    {
        return $user === $product->getUser();
    }

}