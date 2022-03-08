<?php
/**
 * Currency class
 * 
 * @author  Arturo Mora-Rioja
 * @version 1.0, March 2022
 */

    class Currency {
        const apiKey = 'ef739da0-994b-11ec-8e3c-ad75723fab21';

        private string $baseCurrency;
        private float $amount;

        function __construct(string $baseCurrency = 'DKK') {
            $this->baseCurrency = $baseCurrency;
        }

        function convert(float $amount, string $destinationCurrency = 'EUR') {
            $url = 'https://freecurrencyapi.net/api/v2/latest?apikey=' . Currency::apiKey . '&base_currency=' . $this->baseCurrency;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-type: application/json']);
            $response = json_decode(curl_exec($ch), true);
            curl_close($ch);

            return round($amount * $response['data'][$destinationCurrency], 2);
        }
    }
?>