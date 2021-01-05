<?php

require_once __DIR__.'/../models/Place.php';

class Squad{
    //TODO zaimplementowac cookie i dodać tutaj obiekt user

    private $userId;
    private $sport;
    private $noMembers;
    private $fee;
    private $place;
    private $address;
    private $date;

    public function __construct(int $userId,string $sport,int $noMembers, float $fee, int $place,string $address, $date){
        $this->userId=$userId;
        $this->sport=$sport;
        $this->noMembers=$noMembers;
        $this->fee=$fee;
        $this->place=$place;
        $this->address=$address;
        $this->date=$date;
        //die(var_dump($this->date));
}


    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date): void
    {
        $this->date = $date;
    }

    public function getSport() :string
    {
        return $this->sport;
    }

    public function setSport($sport): void
    {
        $this->sport = $sport;
    }

    public function getNoMembers() :int
    {
        return $this->noMembers;
    }

    public function setNoMembers($noMembers): void
    {
        $this->noMembers = $noMembers;
    }

    public function getFee() :float
    {
        return $this->fee;
    }

    public function setFee($fee): void
    {
        $this->fee = $fee;
    }

    public function getPlace() :int
    {
        return $this->place;
    }

    public function setPlace($place): void
    {
        $this->place = $place;
    }

    public function getAddress() :string
    {
        return $this->address;
    }

    public function setAddress($address): void
    {
        $this->address = $address;
    }


}