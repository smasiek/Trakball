<?php

require_once "Repository.php";
require_once __DIR__ . '/../models/Place.php';

class PlaceRepository extends Repository
{
    public function getPlaceUsingID(int $id): ?Place
    {
        if ($id == null) {
            //make sql will have all needed parameters
            return null;
        }
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM places WHERE  id_place=:id
        ');

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $place = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($place == false) {
            //TODO zwrocic exception i potem w security controllerze odebrac ten bladi poprawnie obsluzyc
            return null;
        }
        return new Place(
            $place['id_place'],
            $place['name'],
            $place['city'],
            $place['postal_code'],
            $place['street'],
            $place['latitude'],
            $place['longitude'],
            $place['place_photo']
        );

    }

    public function getPlaceUsingAddress(string $name, string $city, string $street): ?Place
    {
        if ($name == null || $city == null || $street == null) {
            //make sql will have all needed parameters
            return null;
        }
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM places WHERE  name=:name AND city=:city AND street=:street
        ');

        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':city', $city, PDO::PARAM_STR);
        $stmt->bindParam(':street', $street, PDO::PARAM_STR);
        $stmt->execute();

        $place = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($place == false) {
            //TODO zwrocic exception i potem w security controllerze odebrac ten bladi poprawnie obsluzyc
            return null;
        }
        return new Place(
            $place['id_place'],
            $place['name'],
            $place['city'],
            $place['postal_code'],
            $place['street'],
            $place['latitude'],
            $place['longitude'],
            $place['place_photo']
        );

    }

    public function getPlaceID(string $name, string $city, string $street): int
    {

        if ($name == null || $city == null || $street == null) {
            //make sql will have all needed parameters
            return 0;
        }

        $place = $this->getPlaceUsingAddress($name, $city, $street);

        return $place->getId();
    }

    public function getCitiesFromInput(string $input)
    {
        $cityTemplate= '%' . strtolower($input) . '%';
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM places WHERE  LOWER(city) like :city
        ');

        $stmt->bindParam(':city', $cityTemplate, PDO::PARAM_STR);
        $stmt->execute();

        $placesInCity=$stmt->fetchAll();
        $cities=[];

        foreach ($placesInCity as $placeInCity){
            if(!in_array($placeInCity['city'],$cities)){
                $cities[]=$placeInCity['city'];
            }
        }
        return $cities;
    }

    public function getStreetsFromInput(string $cityInput,string $streetInput)
    {
        $cityTemplate= '%' . strtolower($cityInput) . '%';
        $streetTemplate= '%' . strtolower($streetInput) . '%';
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM places WHERE  LOWER(city) like :city AND LOWER(street) like :street
        ');

        $stmt->bindParam(':city', $cityTemplate, PDO::PARAM_STR);
        $stmt->bindParam(':street', $streetTemplate, PDO::PARAM_STR);
        $stmt->execute();

        $streetsInCity=$stmt->fetchAll();
        $streets=[];

        foreach ($streetsInCity as $streetInCity){
            if(!in_array($streetInCity['street'],$streets)){
                $streets[]=$streetInCity['street'];
            }
        }
        return $streets;
    }

    public function getPlaceFromInput(string $cityInput, string $streetInput, string $placeInput)
    {
        $cityTemplate= '%' . strtolower($cityInput) . '%';
        $streetTemplate= '%' . strtolower($streetInput) . '%';
        $placeTemplate= '%' . strtolower($placeInput) . '%';
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM places WHERE  LOWER(city) like :city AND LOWER(street) like :street AND LOWER(name) like :place
        ');

        $stmt->bindParam(':city', $cityTemplate, PDO::PARAM_STR);
        $stmt->bindParam(':street', $streetTemplate, PDO::PARAM_STR);
        $stmt->bindParam(':place', $placeTemplate, PDO::PARAM_STR);
        $stmt->execute();

        $placesInCity=$stmt->fetchAll();
        $places=[];

        foreach ($placesInCity as $placeInCity){
            if(!in_array($placeInCity['name'],$places)){
                $places[]=$placeInCity['name'];
            }
        }
        return $places;
    }
}