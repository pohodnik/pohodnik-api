<?php
namespace SocialAuther\Adapter;
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
class Telegram extends AbstractAdapter
{
    public function __construct($config)
    {
        parent::__construct($config);

        $this->socialFieldsMap = array(
            'socialId'   => 'id',
            'firstName'  => 'first_name',
            'lastName'   => 'last_name',
            'username'   => 'username',
            'login'   => 'username',
            'email'   => 'username',
            'avatar'     => 'photo_url'

        );

        $this->provider = 'telegram';
    }

    /**
     * Authenticate and return bool result of authentication
     *
     * @return bool|array
     */
    public function authenticate()
    {
        $result = false;
        
        try {
            // Telegram Widget login passes user data via $_GET
            if (isset($_GET['hash'])) {
                $authData = $_GET;
                $verRes = $this->verifyTelegramAuth($authData);
                // Verify the authentication data
                if ($verRes === true) {
                    $this->userInfo = array(
                        'id'         => $authData['id'] ?? null,
                        'first_name' => $authData['first_name'] ?? null,
                        'last_name'  => $authData['last_name'] ?? null,
                        'username'   => $authData['username'] ?? null,
                        'photo_url'  => $authData['photo_url'] ?? null,
                        'auth_date'  => $authData['auth_date'] ?? null,
                        'hash'       => $authData['hash'],
                        'access_token'       => $authData['hash']
                    );
                    
                    return true;
                } else {
                    return array('reason' => 'Telegram authentication failed', 'authData' => $authData, "verificationResult" => $verRes);
                }
            } else {
                return array('reason' => 'No Telegram authentication data received');
            }
        } catch (\Exception $e) {
            return 'Exception thrown: '.$e->getMessage()."\n";
        }

        return $result;
    }

    /**
     * Verify Telegram authentication data
     *
     * @param array $authData
     * @return bool
     */
    private function verifyTelegramAuth($authData)
    {
        $checkHash = $authData['hash'];
        unset($authData['hash']);
        unset($authData['provider']);
        
        $dataCheckArr = [];
        foreach ($authData as $key => $value) {
            $dataCheckArr[] = $key . '=' . $value;
        }
        
        sort($dataCheckArr);
        $dataCheckString = implode("\n", $dataCheckArr);
        
        $secretKey = hash('sha256', $this->clientSecret, true);
        $hash = hash_hmac('sha256', $dataCheckString, $secretKey);

        if (strcmp($hash, $checkHash) === 0) {
            return true;
        }

        print_r(array('need' => $secretKey, 'has' => $hash));
        die();
    }

    /**
     * Prepare params for authentication url
     *
     * @return array
     */
    public function prepareAuthParams()
    {
        return array(
            'auth_url'    => '/auth/telegram',
            'auth_params' => array(
                'bot_id'     => $this->clientId,  // Используем clientId как bot_id
                'origin'     => $this->redirectUri,
                'embed'      => '0',
                'request_access' => 'read'
            )
        );
    }

    /**
     * Get user birthday or null if it is not set
     *
     * @return null
     */
    public function getBirthday()
    {
        return null;
    }

    public function getEmail()
    {
        $result = null;
        if (isset($this->userInfo['username'])) {
            $result =  $this->userInfo['username'];
        }

        return $result;
    }

    
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

    public function getSocialPage()
    {
        $result = null;

        if (isset($this->userInfo['username'])) {
            $result = 'http://t.me/' . $this->userInfo['username'];
        }

        return $result;
    }

    public function getSex()
    {
        $result = 'male';
        return $result;
    }

}