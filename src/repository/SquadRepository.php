<?php

require_once "Repository.php";
require_once __DIR__ . '/../models/Squad.php';
require_once __DIR__ . '/../repository/PlaceRepository.php';
require_once __DIR__ . '/../repository/UserRepository.php';

class SquadRepository extends Repository
{
    public function getSquads(): array
    {
        $result = [];

        $stmt = $this->database->connect()->prepare('
            SELECT * FROM squads
        ');


        $stmt->execute();
        $squads = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $placeRepository = new PlaceRepository();
        $userRepository = new UserRepository();


        foreach ($squads as $squad) {
            $place = $placeRepository->getPlaceUsingID($squad['id_place']);
            $user = $userRepository->getUserUsingID($squad['id_squad_creator']);
            // die(var_dump($place->getName()));


            $result[] = new Squad(
                $squad['id'],
                $squad['id_squad_creator'],
                $user->getName() . " " . $user->getSurname(),
                $squad['sport'],
                $squad['max_members'],
                $squad['fee'],
                $squad['id_place'],
                $place->getName(),
                $place->getAddress(),
                $squad['date']
            );
        }

        return $result;
    }

    public function getYourSquads(): array
    {
        $result = [];

        $stmt = $this->database->connect()->prepare('
            SELECT * FROM users_squads
            INNER JOIN squads ON squads.id=users_squads.id_squad
            INNER JOIN users ON users.id=users_squads.id_user
            WHERE users.id=:id
        ');


        $stmt->bindParam(':id', $_COOKIE['user_id']);
        $stmt->execute();
        $squads = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $placeRepository = new PlaceRepository();
        $userRepository = new UserRepository();

        $user = $userRepository->getUserUsingID($_COOKIE['user_id']);
        foreach ($squads as $squad) {
            $place = $placeRepository->getPlaceUsingID($squad['id_place']);


            $result[] = new Squad(
                $squad['id_squad'],
                $squad['id_squad_creator'],
                $user->getName() . " " . $user->getSurname(),
                $squad['sport'],
                $squad['max_members'],
                $squad['fee'],
                $squad['id_place'],
                $place->getName(),
                $place->getAddress(),
                $squad['date']
            );
        }

        return $result;
    }

    public function addYourSquad(int $squadID)
    {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO users_squads
            VALUES (?,?)
        ');


        $stmt->execute([
            $_COOKIE['user_id'],
            $squadID
        ]);
    }

    public function getSquadUsingID(int $id): ?Squad
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM squads WHERE  id=:id 
        ');

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $squad = $stmt->fetch(PDO::FETCH_ASSOC);

        $placeRepository = new PlaceRepository();
        $userRepository = new UserRepository();

        $place = $placeRepository->getPlaceUsingID($squad['id_place']);
        $user = $userRepository->getUserUsingID($_COOKIE['user_id']);

        if ($squad == false) {
            //TODO zwrocic exception i potem w security controllerze odebrac ten bladi poprawnie obsluzyc
            return null;
        }
        return new Squad(
            $squad['id'],
            $squad['id_squad_creator'],
            $user->getName() . " " . $user->getSurname(),
            $squad['sport'],
            $squad['max_members'],
            $squad['fee'],
            $squad['id_place'],
            $squad[$place->getName()],
            $squad[$place->getAddress()],
            $squad['date']
        );

    }

    public function getPublishedSquad($creatorID, $date, $placeID): ?Squad
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM squads WHERE  id_squad_creator=:creatorID AND date=:date AND id_place=:placeID 
        ');


        $stmt->bindParam(':creatorID', $creatorID, PDO::PARAM_INT);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $stmt->bindParam(':placeID', $placeID, PDO::PARAM_INT);
        $stmt->execute();

        $squad = $stmt->fetch(PDO::FETCH_ASSOC);

        $placeRepository = new PlaceRepository();
        $userRepository = new UserRepository();

        $place = $placeRepository->getPlaceUsingID($squad['id_place']);
        $user = $userRepository->getUserUsingID($creatorID);

        if ($squad == false) {
            //TODO zwrocic exception i potem w security controllerze odebrac ten bladi poprawnie obsluzyc
            return null;
        }
        return new Squad(
            $squad['id'],
            $squad['id_squad_creator'],
            $user->getName() . " " . $user->getSurname(),
            $squad['sport'],
            $squad['max_members'],
            $squad['fee'],
            $squad['id_place'],
            $place->getName(),
            $place->getAddress(),
            $squad['date']
        );
    }

    public function addSquad($creatorID, $sport, $maxMembers, $fee, $date, $placeID): void
    {
        $currDate = new DateTime();
        $stmt = $this->database->connect()->prepare('
        INSERT INTO squads (id_squad_creator,sport,max_members,fee,created_at,date,id_place)
        VALUES(?,?,?,?,?,?,?)
        ');
        //todo POBRAC TO Z SESJI A NIE KODOWANE NA SZTYWNO


        $stmt->execute([
            $creatorID,
            $sport,
            $maxMembers,
            $fee,
            $currDate->format('Y-m-d'),
            $date,
            $placeID
        ]);
    }

    public function findCity(string $city): bool
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.places WHERE  city=:city
        ');

        $stmt->bindParam(':city', $city, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result == false) {
            return false;
        } else {
            return true;
        }
    }

    public function findStreet(string $street): bool
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.places WHERE  street=:street
        ');

        $stmt->bindParam(':street', $street, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result == false) {
            return false;
        } else {
            return true;
        }
    }

    public function findPlace(string $place): bool
    {
        $stmt = $this->database->connect()->prepare('
            SELECT * FROM public.places WHERE  name=:name
        ');

        $stmt->bindParam(':name', $place, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result == false) {
            return false;
        } else {
            return true;
        }
    }

    public function getSquadMembers(int $squadID): array
    {
        $result = [];

        $stmt = $this->database->connect()->prepare('
            SELECT * FROM users_squads where id_squad=:squadID
        ');

        $stmt->bindParam(':squadID', $squadID);


        $stmt->execute();
        $membersID = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($squadID == 2) {
            die(var_dump($membersID));
        }
        $userRepository = new UserRepository();

        foreach ($membersID as $memberID) {
            $result[] = $userRepository->getUserUsingID($memberID['id_user']);
        }

        return $result;
    }

    public function getSquadBySearch(string $searchString)
    {
        $searchString = '%' . strtolower($searchString) . '%';
        $userRepository = new UserRepository();

        $stmt = $this->database->connect()->prepare('
        SELECT * FROM squad_info
        WHERE LOWER(place) LIKE :search OR LOWER(surname) LIKE :search OR LOWER(name) LIKE :search OR CAST(date AS VARCHAR) = :search;
        ');
        $stmt->bindParam(':search', $searchString);
        $stmt->execute();

        $info = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $basicSquadInfo=['basic'=>$info];


        foreach ($basicSquadInfo['basic'] as $infos) {

            $stmt = $this->database->connect()->prepare('
        SELECT * FROM users_squads
        WHERE id_squad=:id_squad
        ');
            $stmt->bindParam(':id_squad', $infos['id']);
            $stmt->execute();

            $members = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $basicSquadInfo["squad_count"] = sizeof($members);

            $i = 0;
            foreach($members as $member){
                if ($i < 5 and $member['id_user']!=null) {
                    $basicSquadInfo['basic'][]=["member_" . $i . "_photo" => $userRepository->getUserUsingID($member['id_user'])->getPhoto()];
                } else {
                    break;
                }
                $i++;
            }
        }

        return $basicSquadInfo;
    }

    public function join_squad($userID, $squadID): bool
    {
        $stmt = $this->database->connect()->prepare('
        SELECT * FROM users_squads WHERE id_user=:id_user AND id_squad=:id_squad
        ');
        $stmt->bindParam(':id_user', $userID);
        $stmt->bindParam(':id_squad', $squadID);
        $stmt->execute();

        $possibleDuplicate = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($possibleDuplicate['id_user'] != null) {
            //users has already joined this squad
            return false;
        }

        $stmt = $this->database->connect()->prepare('
        INSERT INTO users_squads
        VALUES (?,?)
        ');

        return $stmt->execute([
            $userID,
            $squadID
        ]);
    }

    public function leave_squad($userID, $squadID)
    {

        $stmt = $this->database->connect()->prepare('
        SELECT * FROM squads WHERE id=:squadID AND id_squad_creator=:creatorID
        ');
        $stmt->bindParam(':squadID', $squadID, PDO::PARAM_INT);
        $stmt->bindParam(':creatorID', $userID, PDO::PARAM_INT);
        $stmt->execute();
        $possibleSquad = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($possibleSquad['id_squad_creator'] == $userID) {
            $stmt = $this->database->connect()->prepare('
                DELETE FROM squads
                WHERE id=:squadID
             ');
            $stmt->bindParam(':squadID', $squadID, PDO::PARAM_INT);
            return $stmt->execute();
        }

        $stmt = $this->database->connect()->prepare('
        DELETE FROM users_squads
        WHERE id_user=:userID AND id_squad=:squadID
        ');

        $stmt->bindParam(':squadID', $squadID, PDO::PARAM_INT);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->execute();
    }


}




















