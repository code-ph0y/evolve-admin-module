<?php

namespace AdminModule\Entity;

class User
{
    protected $id            = null;
    protected $user_level_id = null;
    protected $username      = null;
    protected $first_name    = null;
    protected $last_name     = null;
    protected $email         = null;

    // Virtual
    protected $level_title   = null;

    public function __construct($data = array())
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }

    }


    /**
     * Get the value of Id
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of Username
     *
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Get the value of First Name
     *
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Get the value of Last Name
     *
     * @return mixed
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Get the value of Email
     *
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the value of Level Title
     *
     * @return mixed
     */
    public function getLevelTitle()
    {
        return $this->level_title;
    }

   /**
    * Get the value of First Name and Last Name
    *
    * @return mixed
    */
    public function getFullName()
    {
        return $this->getFirstName() . ' ' . $this->getLastName();
    }

    /**
     * Get the value of User Level Id
     *
     * @return mixed
     */
    public function getUserLevelId()
    {
        return $this->user_level_id;
    }

}
