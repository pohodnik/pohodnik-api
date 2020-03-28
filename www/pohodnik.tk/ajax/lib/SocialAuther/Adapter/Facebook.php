<?php

namespace SocialAuther\Adapter;

class Facebook extends AbstractAdapter
{
    public function __construct($config)
    {
        parent::__construct($config);

        $this->socialFieldsMap = array(
            'socialId'   => 'id',
            'email'      => 'email',
            'name'       => 'name',
            'socialPage' => 'link',
            'sex'        => 'gender',
			'avatar'	 => 'picture_large',
            'birthday'   => 'birthday'
        );

        $this->provider = 'facebook';
    }

    /**
     * Get url of user's avatar or null if it is not set
     *
     * @return string|null
     */
    public function getAvatar()
    {
        $result = null;
        if (isset($this->userInfo['picture_large'])) {
            $result =  $this->userInfo['picture_large']['data']['url'] ;
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

        if (isset($_GET['code'])) {
            $params = array(
                'client_id'     => $this->clientId,
                'redirect_uri'  => $this->redirectUri,
                'client_secret' => $this->clientSecret,
                'code'          => $_GET['code']
            );
			$tokenInfo = json_decode($this->get('https://graph.facebook.com/oauth/access_token', $params, false), true);
           
		   			echo '<pre>';
			print_r($tokenInfo);
			echo '</pre>';
		   
            if (count($tokenInfo) > 0 && isset($tokenInfo['access_token'])) {
                $params = array(
					'access_token' => $tokenInfo['access_token'], 
					'fields'=> 'id,birthday,email,first_name,gender,last_name,link,picture.width(999999).as(picture_large),picture,middle_name,name'
				);
                $userInfo = $this->get('https://graph.facebook.com/v2.6/me', $params);

                if (isset($userInfo['id'])) {
                    $this->userInfo = $userInfo;
					//print_r($userInfo);
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
            'auth_url'    => 'https://www.facebook.com/dialog/oauth',
            'auth_params' => array(
                'client_id'     => $this->clientId,
                'redirect_uri'  => $this->redirectUri,
                'response_type' => 'code',
               'scope'         => 'email,user_birthday'
            )
        );
    }
}