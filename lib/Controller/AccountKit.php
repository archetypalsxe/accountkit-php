<?php

namespace Controller;

use \Connection\AccountKit as AccountKitConnection;
use \Exception;
use \Model\AccessData as AccessDataModel;
use \Model\User as UserModel;
use \Model\UserData as UserDataModel;

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
            $user = new UserModel();
            $user->setAccessDataModel($accessData);
            $user->setUserDataModel($this->retrieveUserData($accessData));
            return $user;
        } catch (\Exception $e) {
            trigger_error($e->getMessage(), E_USER_NOTICE);
        }
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

    /**
     * Retrieve a user data model based on the provided access data model
     *
     * @param AccessDataModel
     * @return UserDataModel
     */
    protected function retrieveUserData(AccessDataModel $accessData)
    {
        $connection = new AccountKitConnection();
        return $connection->sendAccessData($accessData);
    }
}
