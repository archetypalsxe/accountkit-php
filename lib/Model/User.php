<?php

namespace Model;

use \Model\AccessData as AccessDataModel;
use \Model\UserData as UserDataModel;

/**
 * Class for holding a user's information
 */
class User
{
    /**
     * Access data model received from Account Kit
     *
     * @var AccessDataModel
     */
    protected $accessDataModel;

    /**
     * User data received from Account Kit
     *
     * @var UserDataModel
     */
    protected $userDataModel;

    /**
     * Set this model's access data model
     *
     * @param AccessDataModel $model
     */
    public function setAccessDataModel(AccessDataModel $model)
    {
        $this->accessDataModel = $model;
    }

    /**
     * Set this model's user data model
     *
     * @param UserDataModel $model
     */
    public function setUserDataModel(UserDataModel $model)
    {
        $this->userDataModel = $model;
    }

    /**
     * Returns the user's ID
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->accessDataModel->getUserId();
    }

    /**
     * Returns the user's phone number
     *
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->userDataModel->getPhoneNumber();
    }

    /**
     * Returns the user's email address
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->userDataModel->getEmail();
    }

    /**
     * Returns the user's access token
     *
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessDataModel->getAccessToken();
    }

    /**
     * Returns the user's refresh interval
     *
     * @return int
     */
    public function getRefreshInterval()
    {
        return $this->accessDataModel->getRefreshInterval();
    }
}
