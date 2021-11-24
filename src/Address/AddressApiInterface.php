<?php 

namespace App\Address;

interface AddressApiInterface
{
    public function searchAddress(string $search): array;
}