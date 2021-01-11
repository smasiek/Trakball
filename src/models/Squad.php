<?php

require_once __DIR__.'/../models/Place.php';

class Squad{
    //TODO zaimplementowac cookie i dodać tutaj obiekt user

    private $id;
    private $creatorID;
    private $creatorName;
    private $sport;
    private $maxMembers;
    private $fee;
    private $placeName;
    private $placeID;
    private $address;
    private $date;

    public function __construct(int $id,int $userId, string $creatorName,string $sport,int $maxMembers, float $fee, int $placeID, string $placeName, string $address, $date){
        $this->id=$id;
        $this->creatorID=$userId;
        $this->creatorName=$creatorName;
        $this->sport=$sport;
        $this->maxMembers=$maxMembers;
        $this->fee=$fee;
        $this->placeName=$placeName;
        $this->placeID=$placeID;
        $this->address=$address;
        $this->date=$date;
}

    public function getID(): int
    {
        return $this->id;
    }

    public function getCreatorID(): int
    {
        return $this->creatorID;
    }

    public function getCreatorName(): string
    {
        return $this->creatorName;
    }

    public function getDate()
    {
        $splited=explode("T",$this->date);

        return $splited[0]." ".$splited[1];
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

    public function getMaxMembers() :int
    {
        return $this->maxMembers;
    }

    public function setMaxMembers($maxMembers): void
    {
        $this->maxMembers = $maxMembers;
    }

    public function getFee() :float
    {
        return $this->fee;
    }

    public function setFee($fee): void
    {
        $this->fee = $fee;
    }

    public function getPlaceName() :string
    {
        return $this->placeName;
    }

    public function setPlaceName($placeName): void
    {
        $this->placeName = $placeName;
    }

    public function getAddress() :string
    {
        return $this->address;
    }

    public function setAddress($address): void
    {
        $this->address = $address;
    }

    public function getPlaceID(): int
    {
        return $this->placeID;
    }


}