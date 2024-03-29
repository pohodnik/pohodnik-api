<?php

namespace SocialAuther\Adapter;

class Vk extends AbstractAdapter
{
    public function __construct($config)
    {
        parent::__construct($config);

        $this->socialFieldsMap = array(
            'socialId'   => 'id',
            'email'      => 'email',
            'avatar'     => 'photo_big',
            'birthday'   => 'bdate'
        );

        $this->provider = 'vk';
    }

    /**
     * Get user name or null if it is not set
     *
     * @return string|null
     */
    public function getName()
    {
        $result = null;

        if (isset($this->userInfo['first_name']) && isset($this->userInfo['last_name'])) {
            $result = $this->userInfo['first_name'] . ' ' . $this->userInfo['last_name'];
        } elseif (isset($this->userInfo['first_name']) && !isset($this->userInfo['last_name'])) {
            $result = $this->userInfo['first_name'];
        } elseif (!isset($this->userInfo['first_name']) && isset($this->userInfo['last_name'])) {
            $result = $this->userInfo['last_name'];
        }

        return $result;
    }

    /**
     * Get user social id or null if it is not set
     *
     * @return string|null
     */
    public function getSocialPage()
    {
        $result = null;

        if (isset($this->userInfo['screen_name'])) {
            $result = 'http://vk.com/' . $this->userInfo['screen_name'];
        }

        return $result;
    }

    /**
     * Get user sex or null if it is not set
     *
     * @return string|null
     */
    public function getSex()
    {
        $result = null;
        if (isset($this->userInfo['sex'])) {
            $result = $this->userInfo['sex'] == 1 ? 'female' : 'male';
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
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
                'code' => $_GET['code'],
                'redirect_uri' => $this->redirectUri
            );

            $tokenInfo = $this->get('https://oauth.vk.com/access_token', $params);
			echo '<pre>';
			print_r($tokenInfo);
			echo '</pre>';
            if (isset($tokenInfo['access_token'])) {
                $params = array(
                    'uids'         => $tokenInfo['user_id'],
                    'fields'       => 'uid,first_name,last_name,screen_name,sex,bdate,photo_big',
                    'access_token' => $tokenInfo['access_token'],
					'v'=>'5.131'
                );

                $userInfo = $this->get('https://api.vk.com/method/users.get', $params);
                if (isset($userInfo['response'][0]['id'])) {
                    $this->userInfo = $userInfo['response'][0];
					$this->userInfo['email'] = $tokenInfo['email'];
					$this->userInfo['access_token'] = $tokenInfo['access_token'];
                    $result = true;
                } else {
					print_r( $tokenInfo );
					print_r( $userInfo );
					die('sdfsdfsd sf sd s');
				}
            } else {
				print_r($tokenInfo);
				die('err');
			}
        } else {
			die('no code');
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
            'auth_url'    => 'https://oauth.vk.com/authorize',
            'auth_params' => array(
                'client_id'     => $this->clientId,
                'scope'         => 'email',
                'redirect_uri'  => $this->redirectUri,
                'response_type' => 'code',
				'v'=>'5.131'
            )
        );
    }
}
