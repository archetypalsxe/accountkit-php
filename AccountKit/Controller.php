<?php

namespace AccountKit;

use \AccountKit\Connection as AccountKitConnection;
use \AccountKit\Models\AccessData as AccessDataModel;
use \AccountKit\Models\User as UserModel;
use \AccountKit\Models\UserData as UserDataModel;
use \Exception;

class Controller
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

            // @TODO Duplicate code
            $user = new UserModel();
            $user->setUserDataModel($this->retrieveUserData($accessData));
            $user->setAccessDataModel($accessData);

            return $user;
        } catch (Exception $e) {
            trigger_error($e->getMessage(), E_USER_NOTICE);
        }
    }

    /**
     * Revalidate the provided token to make sure it is still valid
     *
     * @param string $token
     * @return UserModel
     */
    public function revalidateToken($token)
    {
        try {
            $model = new AccessDataModel();
            $model->setAccessToken($token);

            // @TODO Combine duplicate code
            $user = new UserModel();
            $user->setUserDataModel($this->retrieveUserData($model));
            $user->setAccessDataModel($model);

            return $user;
        } catch (Exception $e) {
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
