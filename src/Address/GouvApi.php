<?php

namespace App\Address;

class GouvApi implements AddressApiInterface
{
    const URL = "https://api-adresse.data.gouv.fr/search/";

    public function search(string $search): array
    {
        $curl = curl_init();

        // Construit le lien vers l'API
        $url = self::URL . '?' . http_build_query(['q' => $search]);

        curl_setopt($curl, CURLOPT_URL, $url);

        // Indique que la valeur de retour doit être une chaîne
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        // Ne pas vérifier les certificats
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($curl);

        // Transform en array
        return json_decode($result, true) ?? [];
    }
}