<?php

namespace AccountKit\Model;

/**
 * Class for storing the data that is received when getting user data
 */
class UserData
{
    /**
     * The user's phone number
     *
     * @var string
     */
    protected $phoneNumber;

    /**
     * The user's email address
     *
     * @var string
     */
    protected $email;

    /**
     * Retrieves the customer's email address
     *
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Return the customer's phone number
     *
     * @return string
     */
    public function getPhoneNumber() {
        return $this->phoneNumber;
    }

    /**
     * Set the customer's email address
     *
     * @param string $email
     */
    public function setEmail($email) {
        $this->email = (string) $email;
    }

    /**
     * Set the customer's phone number
     *
     * @param string $phoneNumber
     */
    public function setPhoneNumber($phoneNumber) {
        $this->phoneNumber = (string) $phoneNumber;
    }
}
