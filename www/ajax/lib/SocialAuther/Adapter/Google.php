<?php
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
        try {
        
        $GOOGLE_CLIENT_ID = $this->clientId;
        $GOOGLE_CLIENT_SECRET = $this->clientSecret;
        $GOOGLE_REDIRECT_URI = $this->redirectUri;

        if (isset($_GET['code'])) {
            $params = array(
                'client_id'     => $this->clientId,
                'client_secret' => $this->clientSecret,
                'redirect_uri'  => $this->redirectUri,
                'grant_type'    => 'authorization_code',
                'code'          => $_GET['code']
            );

            $tokenInfo = $this->post('https://accounts.google.com/o/oauth2/token', $params);



            if (isset($tokenInfo['access_token'])) {
                $params['access_token'] = $tokenInfo['access_token'];

                $userInfo = $this->get('https://www.googleapis.com/oauth2/v1/userinfo', $params);

                if (isset($userInfo['id']))
                {
                    $this->parseUserData($userInfo);

                    if (isset($this->response['birthday'])) {
                        $birthDate = explode('-', $this->response['birthday']);
                        $this->userInfo['birthDay']   = isset($birthDate[2]) ? $birthDate[2] : null;
                        $this->userInfo['birthMonth'] = isset($birthDate[1]) ? $birthDate[1] : null;
                        $this->userInfo['birthYear']  = isset($birthDate[0]) ? $birthDate[0] : null;
                    }

                    return true;
                } else {
                    return array('reason' => 'USerinfo has no id', 'userInfo' => $userInfo);
                }
            } else {
                return array('reason' => 'Has no access_token in tokenInfo', "token_info" => $tokenInfo, "params" =>  $params);
            }
        } else {
            return array('reason' => 'Has no Query parameter code', "error" => $_GET['error']);
        }

    } catch (Exception $e) {
        return 'Выброшено исключение: '.$e->getMessage()."\n";
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
            'auth_url'    => 'https://accounts.google.com/o/oauth2/auth',
            'auth_params' => array(
                'access_type' => 'offline',
                'redirect_uri'  => $this->redirectUri,
                'response_type' => 'code',
                'client_id'     => $this->clientId,
                'scope'         => 'https://www.googleapis.com/auth/userinfo.email'
            )
        );
    }
}
