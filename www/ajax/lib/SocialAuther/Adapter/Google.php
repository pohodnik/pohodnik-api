<?php
include('../../../../../vendor/autoload.php');
use Google\Client;

namespace SocialAuther\Adapter;

class Google extends AbstractAdapter
{
    public function __construct($config)
    {
        parent::__construct($config);

        $this->socialFieldsMap = array(
            'socialId'   => 'id',
            'email'      => 'email',
            'name'       => 'name',
            'socialPage' => 'link',
            'avatar'     => 'picture',
            'sex'        => 'gender'
        );

        $this->provider = 'google';
    }

    /**
     * Get user birthday or null if it is not set
     *
     * @return string|null
     */
    public function getBirthday()
    {
        if (isset($this->_userInfo['birthday'])) {
            $this->_userInfo['birthday'] = str_replace('0000', date('Y'), $this->_userInfo['birthday']);
            $result = date('d.m.Y', strtotime($this->_userInfo['birthday']));
        } else {
            $result = null;
        }
        return $result;
    }

    /**
     * Authenticate and return bool result of authentication
     *
     * @return bool
     */
    public function authenticate()
    {
        $result = false;

        $client = new Client();
        $client->setApplicationName('People API PHP Quickstart');
        $client->setScopes('https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile openid');
        $client->setAuthConfig('client_secret_569907811449-fc76blolbo9fqb2jduu7mt6tev9e8d1p.apps.googleusercontent.com.json');
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');

        if (isset($_GET['code'])) {
            $params = array(
                'client_id'     => $this->clientId,
                'client_secret' => $this->clientSecret,
                'redirect_uri'  => $this->redirectUri,
                'grant_type'    => 'authorization_code',
                'code'          => $_GET['code'],
                'scope' => 'https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile'
            );

            $tokenInfo = $this->post('https://oauth2.googleapis.com/token', $params);
			echo '<pre>';
			print_r($tokenInfo);
			echo '</pre>';
            if (isset($tokenInfo['access_token'])) {
                $params['access_token'] = $tokenInfo['access_token'];

                $userInfo = $this->get('https://www.googleapis.com/oauth2/v3/userinfo', $params);
                if (isset($userInfo[$this->socialFieldsMap['socialId']])) {
                    $this->userInfo = $userInfo;
                    $this->userInfo['access_token'] = $tokenInfo['access_token'];
                    $result = true;
                }
            }
        }

        return $result;
    }

    /**
     * Prepare params for authentication url
     *
     * @return array
     */
    public function prepareAuthParams()
    {
        return array(
            'auth_url'    => 'https://accounts.google.com/o/oauth2/v2/auth',
            'auth_params' => array(
                'redirect_uri'  => $this->redirectUri,
                'response_type' => 'code',
                'client_id'     => $this->clientId,
                'scope'         => 'https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile'
            )
        );
    }
}