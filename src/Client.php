<?php

namespace Snipworks\GoogleAuth;

/**
 * Class Client
 * @package Snipworks\GoogleAuth
 */
class Client
{

    /** @var string $access_token */
    private $access_token;

    /** @var string $client_id */
    private $client_id;

    /** @var string $client_secret */
    private $client_secret;

    /** @var string $redirect_uri */
    private $redirect_uri;

    /** @var array $scope */
    private $scope = array();

    /** @var string $access_type */
    private $access_type = 'online';

    /** @var string $approval_prompt */
    private $approval_prompt = 'auto';

    /** @var Auth $auth */
    private $auth;

    /** @var User $user */
    private $user;

    /**
     * Class constructor
     */
    public function __construct()
    {
        $this->auth = new Auth($this);
        $this->user = new User($this);
    }

    /**
     * @param string $access_token
     */
    public function setAccessToken($access_token)
    {
        $this->access_token = $access_token;
    }

    /**
     * @param string $client_id
     */
    public function setClientId($client_id)
    {
        $this->client_id = $client_id;
    }

    /**
     * @param string $client_secret
     */
    public function setClientSecret($client_secret)
    {
        $this->client_secret = $client_secret;
    }

    /**
     * @param string $redirect_uri
     */
    public function setRedirectUri($redirect_uri)
    {
        $this->redirect_uri = $redirect_uri;
    }

    /**
     * @param array $scope
     */
    public function setScope($scope)
    {
        $this->scope = $scope;
    }

    /**
     * @param string $access_type
     */
    public function setAccessType($access_type)
    {
        $this->access_type = $access_type;
    }

    /**
     * @param string $approval_prompt
     */
    public function setApprovalPrompt($approval_prompt)
    {
        $this->approval_prompt = $approval_prompt;
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->access_token;
    }

    /**
     * @return string
     */
    public function getClientId()
    {
        return $this->client_id;
    }

    /**
     * @return string
     */
    public function getClientSecret()
    {
        return $this->client_secret;
    }

    /**
     * @return string
     */
    public function getRedirectUri()
    {
        return $this->redirect_uri;
    }

    /**
     * @return array
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * @return string
     */
    public function getAccessType()
    {
        return $this->access_type;
    }

    /**
     * @return string
     */
    public function getApprovalPrompt()
    {
        return $this->approval_prompt;
    }

    /**
     * @return Auth
     */
    public function auth()
    {
        return $this->auth;
    }

    /**
     * @return User
     */
    public function user()
    {
        return $this->user;
    }
}
