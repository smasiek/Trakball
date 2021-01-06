<?php

require_once 'AppController.php';
require_once __DIR__ . '/../repository/SquadRepository.php';
require_once __DIR__ . '/../repository/PlaceRepository.php';
require_once __DIR__ . '/../models/Squad.php';

class NewSquadController extends AppController
{
    public function publish_squad()
    {
        $newSquadRepository=new SquadRepository();
        $placeRepository=new PlaceRepository();
        $userRepository = new UserRepository();

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
        $sport=$_POST["sport"];
        $noMembers=$_POST["max_players"];
        $fee=$_POST["fee"];
        $date=$_POST["date"];

        if ($addressCity == null) {
            return $this->render('new_squad', ['messages' => ['Choose city!']]);
        }
        if(!$newSquadRepository->findCity($addressCity)){
            return $this->render('new_squad', ['messages' => ['Choose correct city!']]);
        }
        if ($addressStreet == null) {
            return $this->render('new_squad', ['messages' => ['Choose street!']]);
        }

        if(!$newSquadRepository->findStreet($addressStreet)){
            return $this->render('new_squad', ['messages' => ['Choose correct street!']]);
        }

        if ($place == null) {
            return $this->render('new_squad', ['messages' => ['Choose place!']]);
        }
        if(!$newSquadRepository->findPlace($place)){
            return $this->render('new_squad', ['messages' => ['Choose correct place!']]);
        }

        $placeId=$placeRepository->getPlaceID($place,$addressCity,$addressStreet);

        if ($sport == null) {
            return $this->render('new_squad', ['messages' => ['Choose sport!']]);
        }
        if ($noMembers == null) {
            return $this->render('new_squad', ['messages' => ['Choose max mebers amount!']]);
        }
        if ($fee == null) {
            return $this->render('new_squad', ['messages' => ['Choose entrance fee!']]);
        }

         if ($date == null) {
             return $this->render('new_squad', ['messages' => ['Choose date of event!']]);
         }

        $newSquadRepository->addSquad( $userId,$sport,$noMembers,$fee,$date,$placeId);
        $publishedSquad=$newSquadRepository->getPublishedSquad($userId,$date,$placeId);
        $newSquadRepository->addYourSquad($publishedSquad->getId());

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/squads");

    }


}