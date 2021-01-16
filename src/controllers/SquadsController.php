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

        $this->cookieCheck();
       /* if(!$this->squadRepository->join_squad($_COOKIE['user_id'],$squadID)){
            // $url = "http://$_SERVER[HTTP_HOST]";
            //  header("Location: {$url}/squads");
            http_response_code(299);
            $squads=$this->squadRepository->getSquads();
            die(var_dump($this->render("squads",['squads'=>$squads,'messages' => "You have already joined this squad!"])));
            return $this->render("squads",['squads'=>$squads,'messages' => "You have already joined this squad!"]);
        };*/


        if(!$this->squadRepository->join_squad($_COOKIE['user_id'],$squadID)){
            echo $this->sendResponse([
                "message"=>"User have been already signed"
            ],406);
            return;
        }


        header("Content-type: application/json");
        http_response_code(200);
        echo json_encode([
            "user_id"=>$_COOKIE["user_id"],
            "squad_id" => $squadID,
            "message"=>"You have joined squad"
        ]);

    }

    private function sendResponse(array $array,int $code) :string{
        header("Content-type: application/json");
        http_response_code($code);
        return json_encode($array);
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

        $this->cookieCheck();
        $contentType= isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]): '';

        if($contentType==='application/json'){
            $content=trim(file_get_contents("php://input"));
            $decoded=json_decode($content,true);

            header('Content-type: application/json');
            http_response_code(200);

          // die(var_dump( $this->squadRepository->getSquadBySearch($decoded['search'])));

            echo json_encode($this->squadRepository->getSquadBySearch($decoded['search'],$_COOKIE['user_id']));
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

    public function delete_squad($id){
        $this->cookieCheck();

        $userRepository=new UserRepository();
        if($userRepository->getUserUsingID($_COOKIE['user_id'])->getRole()==="admin") {
            if (!$this->squadRepository->delete_squad($id)) {
                echo $this->sendResponse([
                    "message" => "U can't delete this squad"
                ], 406);
                return;
            }
            header("Content-type: application/json");
            http_response_code(200);
            echo json_encode([
                "message" => "You have deleted this squad"
            ]);
        } else {
            header("Content-type: application/json");
            http_response_code(403);
            echo json_encode([
                "message" => "U are not admin, how did u get to this action? I'm calling the Police"
            ]);
        }

    }
}


