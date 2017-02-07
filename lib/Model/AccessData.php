<?php

namespace Model;

/**
 * Class for storing data in response to the access token
 */
class AccessData
{
    /**
     * The user's ID
     *
     * @var int
     */
    protected $userId;

    /**
     * The user's access token
     *
     * @var string
     */
    protected $accessToken;

    /**
     * The refresh interval for the user
     *
     * @var int
     */
    protected $refreshInterval;

    /**
     * Returns the user's access token
     *
     * @return string
     */
    public function getAccessToken() {
        return $this->accessToken;
    }

    /**
     * Returns the user's refresh interval
     *
     * @return int
     */
    public function getRefreshInterval() {
        return $this->refreshInterval;
    }

    /**
     * Returns the user's ID
     *
     * @return int
     */
    public function getUserId() {
        return $this->userId;
    }

    /**
     * Sets the access token with the provided access token
     *
     * @param string $accessToken
     */
    public function setAccessToken($accessToken) {
        $this->accessToken = (string) $accessToken;
    }

    /**
     * Sets the refresh interval with the provided interval
     *
     * @param int $refreshInterval
     */
    public function setRefreshInterval($refreshInterval) {
        $this->refreshInterval = (int) $refreshInterval;
    }

    /**
     * Sets the user ID with the provided user ID
     */
    public function setUserId($userId) {
        $this->userId = (int) $userId;
    }
}
