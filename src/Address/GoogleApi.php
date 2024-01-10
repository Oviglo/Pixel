<?php 

namespace App\Address;

class GoogleApi implements AddressApiInterface
{
    public function search(string $search): array
    {
        return ['GOOGLE API'];
    }
}