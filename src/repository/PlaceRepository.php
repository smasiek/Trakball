<?php

require_once "Repository.php";
require_once __DIR__ . '/../models/Place.php';

class PlaceRepository extends Repository
{
    public function getPlaceUsingID(int $id): ?Place
    {
        if ($id == null ){
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
        if ($name == null || $city == null || $street == null){
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

        if ($name == null || $city == null || $street == null){
            //make sql will have all needed parameters
            return 0;
        }

        $place = $this->getPlaceUsingAddress($name, $city, $street);

        return $place->getId();
    }

    //TODO: Dodac obsluge join squad, leave squad, ładowanie awatarow ludzi ktorzy dolaczyli(foreach, if >7 zamien na +1,+2 itd)
    // search place w pasku i sklady z tego miejsca
    // JS do sortowania squadow prawdopodobnie

}