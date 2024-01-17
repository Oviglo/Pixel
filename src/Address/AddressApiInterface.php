<?php

namespace App\Address;

interface AddressApiInterface
{
    public function search(string $search): array;
}