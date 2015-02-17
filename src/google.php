<?php

/**
 * Simple Google OAuth class
 * @class Google
 */
class Google
{
    /** Class constants (API URLs) */
    const AUTH_URL = 'https://accounts.google.com/o/oauth2/auth';
    const TOKEN_URL = 'https://accounts.google.com/o/oauth2/token';
    const USER_INFO_URL = 'https://www.googleapis.com/oauth2/v1/userinfo';

    /** Class properties (auth configuration) */
    public $access_token;
    public $client_id;
    public $client_secret;
    public $redirect_uri;
    public $scope = array();
    public $grant_type = 'authorization_code';
    public $response_type = 'code';
    public $access_type = 'online';
    public $approval_prompt = 'auto';

    /**
     * Class constructor
     * -- set config array
     * @param array $config
     */
    public function __construct($config = array())
    {
        foreach ($config as $key => $data) {
            $this->{$key} = $data;
        }
    }

    /**
     * Get login authentication url
     * @return string
     */
    public function getAuthURL()
    {
        $scope = is_array($this->scope) ? $this->scope : array($this->scope);
        $params = array(
            'response_type' => $this->response_type,
            'redirect_uri' => $this->redirect_uri,
            'client_id' => $this->client_id,
            'scope' => implode(' ', $scope),
            'access_type' => $this->access_type,
            'approval_prompt' => $this->approval_prompt
        );

        return self::AUTH_URL . '?' . http_build_query($params, '', '&');
    }

    /**
     * Authenticate code response
     * @param string $code
     * @return string
     * @throws Exception
     */
    public function authenticate($code = null)
    {
        $params = array(
            'code' => $code,
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret,
            'redirect_uri' => $this->redirect_uri,
            'grant_type' => $this->grant_type,
        );

        $this->access_token = $this->post(self::TOKEN_URL, $params);
        return $this->access_token;
    }

    /**
     * Get user info from google
     * @return array
     * @throws Exception
     */
    public function getUser()
    {
        if (!$this->access_token) {
            throw new Exception('Access token cannot be empty');
        }

        $token = json_decode($this->access_token);
        if (!$token) {
            throw new Exception('Invalid access token');
        }

        $header = array("Authorization: $token->token_type $token->access_token");
        $user_info = $this->get(self::USER_INFO_URL, array(), $header);
        return json_decode($user_info, true);
    }

    /**
     * Post data to google api
     * @param $url
     * @param $params
     * @param array $headers
     * @return string
     */
    protected function post($url, $params, $headers = array())
    {
        $headers = array_merge(array("Content-type: application/x-www-form-urlencoded"), $headers);
        return $this->call($url, $params, 'POST', $headers);
    }

    /**
     * Get data from google api
     * @param $url
     * @param $params
     * @param array $headers
     * @return string
     */
    protected function get($url, $params, $headers = array())
    {
        return $this->call($url, $params, 'GET', $headers);
    }

    /**
     * Call api request
     * @param $url
     * @param $params
     * @param $method
     * @param array $headers
     * @return string
     */
    private function call($url, $params, $method, $headers = array())
    {
        $context = array(
            'http' => array(
                'method' => $method,
                'header' => implode("\r\n", $headers),
                'content' => http_build_query($params)
            )
        );

        return file_get_contents($url, false, stream_context_create($context));
    }
}
