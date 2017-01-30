<?php

namespace Controller;

use \Exception;
use \Model\User as UserModel;

class AccountKit
{
    /**
     * Takes in an authirzation code that was received from Account Kit and
     * returns the user's information that Account Kit has on file
     *
     * @param string $authorizationCode
     * @return UserModel
     */
    public function getUserInformation($authorizationCode)
    {
        try {
            // Initialize variables
            $appId = APP_ID;
            $secret = APP_SECRET;
            $version = VERSION;

            // Exchange authorization code for access token
            $token_exchange_url = 'https://graph.accountkit.com/'.$version.'/access_token?'.
              'grant_type=authorization_code'.
              '&code='.$authorizationCode.
              "&access_token=AA|$appId|$secret";
            $data = $this->sendCurl($token_exchange_url);

            $user_id = $data['id'];
            $user_access_token = $data['access_token'];
            $refresh_interval = $data['token_refresh_interval_sec'];

            // Get Account Kit information
            $me_endpoint_url = 'https://graph.accountkit.com/'.$version.'/me?'.
              'access_token='.$user_access_token;
            $data = $this->sendCurl($me_endpoint_url);
            $phone = isset($data['phone']) ? $data['phone']['number'] : '';
            $email = isset($data['email']) ? $data['email']['address'] : '';

            $user = new UserModel();
            $user->userId = $user_id;
            $user->phone = $phone;
            $user->email = $email;
            $user->accessToken = $user_access_token;
            $user->refreshInterval = $refresh_interval;
            return $user;
        } catch (\Exception $e) {
            trigger_error($e->getMessage(), E_USER_NOTICE);
        }
    }

    /**
     * TODO: Move this into different class
     */
    protected function sendCurl($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = json_decode(curl_exec($ch), true);
        curl_close($ch);
        if(!empty($data['error'])) {
            if(!empty($data['error']['message'])) {
                throw new Exception($data['error']['message']);
            }
            throw new Exception("Error received from Account Kit");
        }

        return $data;
    }
}
