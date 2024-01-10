<?php

namespace App\Address;

class GoogleApi implements AddressApiInterface
{
    public function search(string $search): array
    {
        return ['API GOOGLE'];
    }
}