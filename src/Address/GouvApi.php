<?php

namespace App\Address;

class GouvApi implements AddressApiInterface
{
    public const URL = "https://api-adresse.data.gouv.fr/search/?";

    public function search(string $search): array
    {
        $curl = curl_init();

        // URL à appeler
        curl_setopt($curl, CURLOPT_URL, self::URL . http_build_query([
            'q' => $search,
            'limit' => 15
        ]));

        // Indique que la valeur retournée doit être une chaîne
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

        $result = curl_exec($curl);

        curl_close($curl);

        return json_decode($result, true) ?? [];
    }
}