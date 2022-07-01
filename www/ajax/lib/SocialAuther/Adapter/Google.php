<?php
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

        const GOOGLE_SCOPES = [
            'https://www.googleapis.com/auth/userinfo.email',
            'https://www.googleapis.com/auth/userinfo.profile'
        ];
        const GOOGLE_AUTH_URI = 'https://accounts.google.com/o/oauth2/auth';
        const GOOGLE_TOKEN_URI = 'https://accounts.google.com/o/oauth2/token';
        const GOOGLE_USER_INFO_URI = 'https://www.googleapis.com/oauth2/v1/userinfo';


        const GOOGLE_CLIENT_ID = $this->clientId;
        const GOOGLE_CLIENT_SECRET = $this->clientSecret;
        const GOOGLE_REDIRECT_URI = $this->redirectUri;

        if (isset($_GET['code'])) {
            $params = [
                'client_id'     => GOOGLE_CLIENT_ID,
                'client_secret' => GOOGLE_CLIENT_SECRET,
                'redirect_uri'  => GOOGLE_REDIRECT_URI,
                'grant_type'    => 'authorization_code',
                'code'          => $_GET['code'],
            ];

            $tokenInfo = $this->post(GOOGLE_TOKEN_URI, $params);
			echo '<pre>';
			print_r($tokenInfo);
			echo '</pre>';
            if (isset($tokenInfo['access_token'])) {
                $params['access_token'] = $tokenInfo['access_token'];

                $userInfo = $this->get(GOOGLE_USER_INFO_URI, $params);
                if (isset($userInfo[$this->socialFieldsMap['socialId']])) {
                    $this->userInfo = $userInfo;
                    $this->userInfo['access_token'] = $tokenInfo['access_token'];
                    $result = true;
                }
            } else {
                die("WRONG TOKENINFO".$tokenInfo);
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