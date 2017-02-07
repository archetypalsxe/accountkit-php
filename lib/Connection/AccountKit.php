<?php

namespace Connection;

use \Exception;
use \Model\AccessData as AccessDataModel;

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
        $model->userId = $data['id'];
        $model->accessToken = $data['access_token'];
        $model->refreshInterval = $data['token_refresh_interval_sec'];
        return $model;
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
          'grant_type=authorization_code'.
          '&code='.$authCode.
          "&access_token=AA|". APP_ID ."|". APP_SECRET;
    }

    /**
     * Actually send out the CURL request
     *
     * @param string $url
     * @return @TODO Not sure what it's returning
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
