<?php


class Place
{
    private $id;
    private $name;
    private $city;
    private $postal_code;
    private $street;
    private $latitude;
    private $longitude;

    public function getId() :int
    {
        return $this->id;
    }


}