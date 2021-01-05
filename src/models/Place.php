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


    public function __construct(int $id, string $name, string $city, string $postal_code, string $street, float $latitude, float $longitude)
    {
        $this->id = $id;
        $this->name = $name;
        $this->city = $city;
        $this->postal_code = $postal_code;
        $this->street = $street;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }


    public function getId() :int
    {
        return $this->id;
    }


}