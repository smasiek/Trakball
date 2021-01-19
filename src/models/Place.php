<?php


class Place
{
    private int $id;
    private string $name;
    private string $city;
    private string $postal_code;
    private string $street;
    private float $latitude;
    private float $longitude;
    private string $photo;


    public function __construct(int $id, string $name, string $city, string $postal_code, string $street, float $latitude, float $longitude,string $photo)
    {
        $this->id = $id;
        $this->name = $name;
        $this->city = $city;
        $this->postal_code = $postal_code;
        $this->street = $street;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->photo=$photo;
    }


    public function getName(): string
    {
        return $this->name;
    }


    public function getId() :int
    {
        return $this->id;
    }
    public function getAddress(): string
    {
        return $this->city. " " . $this->street;
    }



}