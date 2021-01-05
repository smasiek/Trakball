<?php

require_once "Repository.php";
require_once __DIR__ . '/../models/Place.php';

class PlaceRepository extends Repository
{
    public function getPlace(string $name, string $city, string $street): ?Place
    {
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
            $place['longitude']
        );

    }

    public function getPlaceID(string $name, string $city, string $street): int
    {

        $place=$this->getPlace( $name,  $city,  $street);
        //die(var_dump($street));
        return $place->getId();
    }
}