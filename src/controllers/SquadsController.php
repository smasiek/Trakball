<?php

require_once 'AppController.php';
require_once __DIR__.'/../repository/SquadRepository.php';

class SquadsController extends AppController
{
    private $messages = [];

    private $squadRepository;

    public function __construct()
    {
        parent::__construct();
        $this->squadRepository=new SquadRepository();
    }

    public function squads(){

        if (!isset($_COOKIE['user_id'])) {
            return $this->render('login');
        }

        $squads=$this->squadRepository->getSquads();
        //TODO ZAMIENIC NA getAvailableSquads() ktore zwroci squady w ktorym są wolne miejsca
        $this->render('squads',['squads'=>$squads]);
    }

    public function your_squads(){

        if (!isset($_COOKIE['user_id'])) {
            return $this->render('login');
        }

        $squads=$this->squadRepository->getYourSquads();
        //die(var_dump($squads));
        $this->render('your_squads',['squads'=>$squads]);

    }


    public function edit_photo()
    {
        if ( $this->isPost() && is_uploaded_file($_FILES['file']['tmp_name']) && $this->validate($_FILES['file'])) {

            move_uploaded_file(
                $_FILES['file']['tmp_name'],
                dirname(__DIR__) . self::UPLOAD_DIRECTORY . $_FILES['file']['name']
            );

            $this->userRepository->setPhoto($_COOKIE['user_id'],$_FILES['file']['name']);
            return $this->render('settings', ['messages' => $this->messages,'image'=>$this->userRepository->getPhoto($_COOKIE['user_id'])]);

        }
        //For debugging purpose
        $this->render('squads', ['messages' => $this->messages]);
    }

    public function edit_data()
    {
        if ($this->isPost()) {

            $this->userRepository->editUserData($_COOKIE['user_id']);
            return $this->render('settings',  ['messages' => $this->messages,'image'=>$this->userRepository->getPhoto($_COOKIE['user_id'])]);
        }
        //For debugging purpose
        $this->render('squads', ['messages' => $this->messages]);
    }






    /*public function join_squad(int $squadID){
        //TODO getUserFromCookie()
        // SquadRepository.addUserToSquad(squadID,userID)
        $this->cookieCheck();
        if(!$this->squadRepository->join_squad($_COOKIE['user_id'],$squadID)){
           // $url = "http://$_SERVER[HTTP_HOST]";
          //  header("Location: {$url}/squads");
            http_response_code(299);
            $squads=$this->squadRepository->getSquads();
            return $this->render("squads",['squads'=>$squads,'messages' => "You have already joined this squad!"]);
        };
        http_response_code(200);

        //Zabezpieczenie przed wyswietleniem sposobu dołączania do skladu
        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/squads");
    }*/

    public function join_squad(int $squadID){
        //TODO getUserFromCookie()
        // SquadRepository.addUserToSquad(squadID,userID)
        $this->cookieCheck();
        if(!$this->squadRepository->join_squad($_COOKIE['user_id'],$squadID)){
            // $url = "http://$_SERVER[HTTP_HOST]";
            //  header("Location: {$url}/squads");
            http_response_code(299);
            $squads=$this->squadRepository->getSquads();
            die(var_dump($this->render("squads",['squads'=>$squads,'messages' => "You have already joined this squad!"])));
            return $this->render("squads",['squads'=>$squads,'messages' => "You have already joined this squad!"]);
        };
        http_response_code(200);

        //Zabezpieczenie przed wyswietleniem sposobu dołączania do skladu
        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/your_squads");
    }

    public function leave_squad(int $squadID){
        //TODO getUserFromCookie()
        // SquadRepository.addUserToSquad(squadID,userID)
        $this->cookieCheck();
        $this->squadRepository->leave_squad($_COOKIE['user_id'],$squadID);
        http_response_code(200);

        //Zabezpieczenie przed wyswietleniem sposobu dołączania do skladu
        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/squads");
    }

    public function search(){
        //TODO


        $contentType= isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]): '';

        if($contentType==="application/json"){
            $content=trim(file_get_contents("php://input"));
            $decoded=json_decode($content,true);

            header('Content-type: application/json');
            http_response_code(200);

           die(vardump( $this->squadRepository->getSquadBySearch($decoded['search'])));

            echo json_encode($this->squadRepository->getSquadBySearch($decoded['search']));
        }
    }

    private function validate(array $file): bool
    {
        if ($file['size'] > self::MAX_FILE_SIZE) {
            $this->messages[] = "File is too large for destination file system.";
            return false;
        }
        if (!isset($file['type']) && !in_array($file['type'], self::SUPPORTED_TYPES)) {
            $this->messages[] = 'File type is not supported';
            return false;
        }
        return true;
    }
}


