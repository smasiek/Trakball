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
            SELECT * FROM squad_info
            WHERE date > current_date
        ');

        $stmt->execute();
        $squads = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($squads as $squad) {

            $result[] = new Squad(
                $squad['id'],
                $squad['id_squad_creator'],
                $squad['name'] . " " . $squad['surname'],
                $squad['sport'],
                $squad['max_members'],
                $squad['fee'],
                $squad['id_place'],
                $squad['place'],
                $squad['city']." ".$squad['street'],
                $squad['date']
            );
        }

        return $result;
    }

    public function getYourSquads($userID): array
    {
        $result = [];

        $stmt = $this->database->connect()->prepare('
            SELECT * FROM users_squads
            INNER JOIN squads ON squads.id=users_squads.id_squad
            INNER JOIN users ON users.id=users_squads.id_user
            WHERE users.id=:id and squads.date > current_date
        ');

        $stmt->bindParam(':id', $userID);
        $stmt->execute();
        $squads = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $placeRepository = new PlaceRepository();
        $userRepository = new UserRepository();

        $user = $userRepository->getUserUsingID($userID);
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

    public function addYourSquad(int $squadID,int $userID)
    {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO users_squads
            VALUES (?,?)
        ');

        $stmt->execute([
            $userID,
            $squadID
        ]);
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
            //TODO zwrocic exception i potem obsluzyc
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

    public function getSquadBySearch(string $searchString,  $currentUserID)
    {
        $searchString = '%' . strtolower($searchString) . '%';
        $userRepository = new UserRepository();

        if($currentUserID!=0){
            //check user login state
            $currentUser=$userRepository->getUserUsingID($currentUserID);
            $currentUserRole=$currentUser->getRole();
        }else{
            $currentUserRole="unlogged";
        }

        $stmt = $this->database->connect()->prepare('
        SELECT * FROM squad_info
        WHERE date > current_date and (LOWER(place) LIKE :search OR LOWER(surname) LIKE :search OR LOWER(name) LIKE :search OR CAST(date AS VARCHAR) LIKE :search);
        ');
        $stmt->bindParam(':search', $searchString);
        $stmt->execute();

        $basicSquadInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $export=[];
        foreach ($basicSquadInfo as $infos) {

            $stmt = $this->database->connect()->prepare('
        SELECT * FROM users_squads
        WHERE id_squad=:id_squad
        ');
            $stmt->bindParam(':id_squad', $infos['id']);
            $stmt->execute();

            $members = $stmt->fetchAll(PDO::FETCH_ASSOC);
           // $export[]=array_merge($infos,$tempArray);
            $memberPhotos=[];
            $i = 0;
            foreach($members as $member){
                if ($i < 5 and $member['id_user']!=null) {
                    $memberPhotos=array_merge($memberPhotos,["member_" . $i . "_photo" => $userRepository->getUserUsingID($member['id_user'])->getPhoto()]);
                } else {
                    break;
                }
                $i++;
            }
            $export[]=array_merge($infos,["squad_count" => sizeof($members)],$memberPhotos,["role"=>$currentUserRole]);
        }

        return $export;
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
            $this->delete_squad($squadID);
        }

        $stmt = $this->database->connect()->prepare('
        DELETE FROM users_squads
        WHERE id_user=:userID AND id_squad=:squadID
        ');

        $stmt->bindParam(':squadID', $squadID, PDO::PARAM_INT);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function delete_squad($squadID){
        $stmt = $this->database->connect()->prepare('
                DELETE FROM squads
                WHERE id=:squadID
             ');
        $stmt->bindParam(':squadID', $squadID, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getSquadCreator(int $id)
    {

        $stmt = $this->database->connect()->prepare('
            SELECT * FROM squads where id=:squadID
        ');

        $stmt->bindParam(':squadID', $id);
        $stmt->execute();
        $squad=$stmt->fetch(PDO::FETCH_ASSOC);
        $userRepository=new UserRepository();
        return $userRepository->getUserUsingID($squad['id_squad_creator']);
    }
}




















