<?php

require_once 'AppController.php';
require_once __DIR__ . '/../repository/SquadRepository.php';


class SquadsController extends AppController
{
    private $messages = [];

    //TODO sprawdzic czy require_one jest w ogole potrzebne

    private $squadRepository;
    private $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->squadRepository = new SquadRepository();
        $this->userRepository = new UserRepository();
    }

    public function squads()
    {
        //cookie check omitted on purpose
        $squads = $this->squadRepository->getSquads();
        $this->render('squads', ['squads' => $squads]);
    }

    public function your_squads()
    {

        $userID = $this->cookieCheck();
        if ($userID != 0) {
            $squads = $this->squadRepository->getYourSquads($userID);
            return $this->render('your_squads', ['squads' => $squads]);
        }
        return 0;
    }


    public function join_squad(int $squadID)
    {

        $userID = $this->cookieCheck();
        /* if(!$this->squadRepository->join_squad($_COOKIE['user_id'],$squadID)){
             // $url = "http://$_SERVER[HTTP_HOST]";
             //  header("Location: {$url}/squads");
             http_response_code(299);
             $squads=$this->squadRepository->getSquads();
             die(var_dump($this->render("squads",['squads'=>$squads,'messages' => "You have already joined this squad!"])));
             return $this->render("squads",['squads'=>$squads,'messages' => "You have already joined this squad!"]);
         };*/

        if ($userID != 0) {
            if (!$this->squadRepository->join_squad($userID, $squadID)) {
                echo $this->sendResponse([
                    "message" => "You have joined this squad already!"
                ], 406);
                return 0;
            }


            header("Content-type: application/json");
            http_response_code(200);
            echo json_encode([
                "user_id" => $userID,
                "squad_id" => $squadID,
                "message" => "You have joined squad"
            ]);
        }
        return 0;
    }

    private function sendResponse(array $array, int $code): string
    {
        header("Content-type: application/json");
        http_response_code($code);
        return json_encode($array);
    }

    public function leave_squad(int $squadID)
    {
        $userID = $this->cookieCheck();
        if ($userID != 0) {
            $this->squadRepository->leave_squad($userID, $squadID);
            http_response_code(200);

            //Zabezpieczenie przed wyswietleniem sposobu dołączania do skladu
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/squads");
        }
    }


    public function search()
    {

        $userID = $this->getCurrentUserID();

        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
        if ($contentType === 'application/json') {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-type: application/json');
            http_response_code(200);

            echo json_encode($this->squadRepository->getSquadBySearch($decoded['search'], $userID));
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

    public function delete_squad($id)
    {
        $userID = $this->cookieCheck();

        if ($userID != 0) {
            if ($this->userRepository->getUserUsingID($userID)->getRole() === "admin") {
                if (!$this->squadRepository->delete_squad($id)) {
                    echo $this->sendResponse([
                        "message" => "U can't delete this squad"
                    ], 406);
                }
                header("Content-type: application/json");
                http_response_code(200);
                echo json_encode([
                    "message" => "You have deleted this squad"
                ]);
                return 0;
            } else {
                header("Content-type: application/json");
                http_response_code(403);
                echo json_encode([
                    "message" => "U are not admin, how did u get to this action? I'm calling the Police"
                ]);
                return 0;
            }

        }
        return 0;
    }

    public function text_organizer(int $id)
    {
        $userID = $this->cookieCheck();

        if ($userID != 0) {
            $creator = $this->squadRepository->getSquadCreator($id);

            $message = "Phone number: " . $creator->getPhone() . "\n" .
                "Email: " . $creator->getEmail();

            echo $this->sendResponse([
                "message" => $message
            ], 200);

        }

    }

    //TODO ZAMIENIC WSZYSTKIE HEADERY I HTTP RESPONSE CODE na funkcje sendResponse()
}


