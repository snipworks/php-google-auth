<?php

namespace Snipworks\GoogleAuth;

/**
 * Class Auth
 * @package Snipworks\GoogleAuth
 */
class Auth
{
    /** @var Client $client */
    private $client;

    /**
     * Create new Auth class
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Create login authentication url
     * @return string
     */
    public function createAuthURL()
    {
        $data = array(
            'response_type' => 'code',
            'redirect_uri' => $this->client->getRedirectUri(),
            'client_id' => $this->client->getClientId(),
            'scope' => implode(' ', $this->client->getScope()),
            'access_type' => $this->client->getAccessType(),
            'approval_prompt' => $this->client->getApprovalPrompt()
        );

        return Request::AUTH_URL . '?' . http_build_query($data, '', '&');
    }

    /**
     * Authenticate code response
     * @param $code
     * @return string
     */
    public function authenticate($code)
    {
        $data = array(
            'code' => $code,
            'client_id' => $this->client->getClientId(),
            'client_secret' => $this->client->getClientSecret(),
            'redirect_uri' => $this->client->getRedirectUri(),
            'grant_type' => 'authorization_code',
        );

        $access_token = Request::post(Request::TOKEN_URL, $data);
        $this->client->setAccessToken($access_token);

        return $this->client->getAccessToken();
    }
}
