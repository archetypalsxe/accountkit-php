<?php

namespace AccountKit\Connection;

use \AccountKit\Model\AccessData as AccessDataModel;
use \AccountKit\Model\UserData as UserDataModel;
use \Exception;

class AccountKit
{
    /**
     * Sends out a request to get an authorization code from an access token
     *
     * @param string $authCode
     * @return AccessDataModel
     * @throws Exception
     */
    public function sendAuthCode($authCode)
    {
        $data = $this->sendRequest($this->getAccessTokenUrl($authCode));
        $model = new AccessDataModel();
        $model->setUserId($data['id']);
        $model->setAccessToken($data['access_token']);
        $model->setRefreshInterval($data['token_refresh_interval_sec']);
        return $model;
    }

    /**
     * Send the access token to Account Kit for the user data
     *
     * @param AccessDataModel $accessData
     * @return UserDataModel
     */
    public function sendAccessData(AccessDataModel $accessData)
    {
        $data = $this->sendRequest($this->getUserDataUrl($accessData));
        $model = new UserDataModel();
        $model->setPhoneNumber(
            !empty($data['phone']['number']) ?
                $data['phone']['number'] :
                ''
        );
        $model->setEmail(
            !empty($data['email']['address']) ?
                $data['email']['address'] :
                ''
        );
        return $model;
    }

    /**
     * Generates a URL to send AccountKit based on provided access data
     *
     * @param AccessDataModel $accessData
     * @return string
     */
    protected function getUserDataUrl(AccessDataModel $accessData)
    {
        return
            'https://graph.accountkit.com/'. VERSION .'/me?access_token='.
            $accessData->getAccessToken();
    }

    /**
     * Get the URL for obtaining an access token
     *
     * @param string $authCode
     * @return string
     */
    protected function getAccessTokenUrl($authCode)
    {
        return 'https://graph.accountkit.com/'. VERSION .'/access_token?'.
          'grant_type=authorization_code&code='.$authCode.
          "&access_token=AA|". APP_ID ."|". APP_SECRET;
    }

    /**
     * Actually send out the CURL request
     *
     * @param string $url
     * @return string[]
     * @throws Exception
     */
    protected function sendRequest($url)
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
