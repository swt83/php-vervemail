<?php

namespace Travis;

use Travis\XML;

class VerveMail
{
    /**
     * Make an API request.
     *
     * @param   string  $key
     * @param   string  $secret
     * @param   string  $method
     * @param   array   $arguments
     * @param   int     $timeout
     * @return  array
     */
    public static function run($key, $secret, $method, $arguments = [], $timeout = 30)
    {
        // set endpoint
        $url = 'https://email.vervemail.com/api/xmlrpc/index.php';

        // patch arguments
        $arguments = array_merge(['methodName' => $method], $arguments);

        // prepare xml schema
        $array = [
            'authentication' => [
                'api_key' => $key,
                'shared_secret' => $secret,
                'response_type' => 'xml',
            ],
            'data' => [
                'methodCall' => $arguments,
            ],
        ];

        // convert to xml
        $xml = XML::fromArray($array)->toString('api');

        // prepare payload
        $payload = http_build_query(['data' => $xml]);

        // make curl request
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded',
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        $response = curl_exec($ch);

        // catch errors...
        if (curl_errno($ch))
        {
            #$errors = curl_error($ch);

            $result = false;
        }
        else
        {
            $result = XML::fromString($response)->toArray();
        }

        // close
        curl_close($ch);

        // return
        return $result;
    }
}