<?php

namespace App\Models;

class ApiRequest
{
    /**
     * @param $uri
     * @param $method
     * @param null $body
     * @return array
     */
    private function withBearer($uri, $method, $body = null)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $uri);
        curl_setopt($ch, CURLOPT_HEADER, TRUE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Authorization: Bearer " . config("global.token")));

        if ($method === "POST") {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        }

        $head = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);

        curl_close($ch);

        $body = substr($head, $header_size);

        return ["body" => json_decode($body), "statusCode" => $httpCode];
    }
}
