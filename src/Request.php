<?php

namespace Snipworks\GoogleAuth;

/**
 * Class Request
 * @package Snipworks\GoogleAuth
 */
class Request
{
    const AUTH_URL = 'https://accounts.google.com/o/oauth2/auth';
    const TOKEN_URL = 'https://accounts.google.com/o/oauth2/token';
    const USER_INFO_URL = 'https://www.googleapis.com/oauth2/v1/userinfo';

    /**
     * Post data to google api
     * @param $url
     * @param $data
     * @param array $headers
     * @return string
     */
    public static function post($url, $data, $headers = array())
    {
        $headers[] = "Content-type: application/x-www-form-urlencoded";
        return self::call($url, $data, 'POST', $headers);
    }

    /**
     * Get data from google api
     * @param $url
     * @param $data
     * @param array $headers
     * @return string
     */
    public static function get($url, $data, $headers = array())
    {
        $url = sprintf('%s?%s', $url, http_build_query($data));
        return self::call($url, array(), 'GET', $headers);
    }

    /**
     * @param $url
     * @param array $data
     * @param $method
     * @param array $headers
     * @return mixed
     * @throws GoogleAuthException
     */
    private static function call($url, $data = array(), $method, $headers = array())
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, strtoupper(trim($method)));
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        $response = curl_exec($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($http_code !== 200) {
            throw new GoogleAuthException("Error calling URL '$url' (code='$http_code')");
        }

        return $response;
    }
}
