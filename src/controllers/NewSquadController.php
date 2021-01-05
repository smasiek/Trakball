<?php

require_once 'AppController.php';
require_once __DIR__ . '/../repository/NewSquadRepository.php';
require_once __DIR__ . '/../repository/PlaceRepository.php';
require_once __DIR__ . '/../models/Squad.php';

class NewSquadController extends AppController
{
    public function publish_squad()
    {
        $newSquadRepository=new NewSquadRepository();
        $placeRepository=new PlaceRepository();

        if (!$this->isPost()) {
            if(isset($_COOKIE['user_id'])){
                return $this->render('new_squad');
            }
            return $this->render('login');
        }

        $userId=$_COOKIE["user_id"];

        $addressCity=$_POST["city"];
        $addressStreet=$_POST["street"];
        $place=$_POST["name"];

        $placeId=$placeRepository->getPlaceID($place,$addressCity,$addressStreet);


        $sport=$_POST["sport"];
        $noMembers=$_POST["max_players"];
        $fee=$_POST["fee"];
        $date=$_POST["date"];

        $newSquadRepository->addSquad( new Squad($userId,$sport,$noMembers,$fee,$placeId,$addressCity." ".$addressStreet,$date));

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/squads");

    }


}