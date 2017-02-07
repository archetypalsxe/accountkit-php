<?php

namespace Controller;

use \Model\AccessData as AccessDataModel;
use \Connection\AccountKit as AccountKitConnection;
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
            $accessData = $this->retrieveAccessData($authorizationCode);

            // Get Account Kit information
            $me_endpoint_url = 'https://graph.accountkit.com/'. VERSION
                .'/me?access_token='.$accessData->accessToken;
            $data = $this->sendCurl($me_endpoint_url);
            $phone = isset($data['phone']) ? $data['phone']['number'] : '';
            $email = isset($data['email']) ? $data['email']['address'] : '';

            $user = new UserModel();
            $user->userId = $accessData->userId;
            $user->phone = $phone;
            $user->email = $email;
            $user->accessToken = $accessData->accessToken;
            $user->refreshInterval = $accessData->refreshInterval;
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

    /**
     * Send the authorization code to Account Kit in order to get access
     * data back
     *
     * @param string $authorizationCode
     * @return AccessDataModel
     */
    protected function retrieveAccessData($authorizationCode)
    {
        $connection = new AccountKitConnection();
        return $connection->sendAuthCode($authorizationCode);
    }
}
