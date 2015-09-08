<?php

namespace Snipworks\GoogleAuth;

/**
 * Class User
 * @package Snipworks\GoogleAuth
 */
class User
{
    /** @var Client $client */
    private $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get user info from google
     * @return array
     * @throws GoogleAuthException
     */
    public function get()
    {
        $access_token = $this->client->getAccessToken();
        if (!$access_token) {
            throw new GoogleAuthException('Access token cannot be empty');
        }

        $token = json_decode($access_token, true);
        if (!$token) {
            throw new GoogleAuthException('Invalid access token format');
        }

        $header = array("Authorization: {$token['token_type']} {$token['access_token']}");
        $user_info = Request::get(Request::USER_INFO_URL, array(), $header);

        return json_decode($user_info, true);
    }
}
