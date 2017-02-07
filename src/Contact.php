<?php

class Contact
{
    private $name;
    private $email;
    private $phone;

    function __construct($name, $email, $phone)
    {
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
    }

    function get($property)
    {
        return $this->$property;
    }

    function set($property, $value)
    {
        $this->$property = $value;
    }
}

?>
