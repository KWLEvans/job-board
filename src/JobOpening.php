<?php

    class JobOpening
    {
        private $title;
        private $description;
        private $contact;

        function __construct($title, $description, $contact)
        {
            $this->title = $title;
            $this->description = $description;
            $this->contact = $contact;
        }

        function get($property)
        {
            return $this->$property;
        }

        function set($property, $value)
        {
            $this->$property = $value;
        }

        function save()
        {
            array_push($_SESSION['list_of_jobs'], $this);
        }

        static function getAll()
        {
            return $_SESSION['list_of_jobs'];
        }
    }

?>
