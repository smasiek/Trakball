<?php

require_once 'AppController.php';


class SquadsController extends AppController
{
    private array $messages = [];

    private SquadRepository $squadRepository;
    private UserRepository $userRepository;

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

        if ($userID != 0) {
            if (!$this->squadRepository->join_squad($userID, $squadID)) {
                echo $this->sendResponse([
                    "message" => "You have joined this squad earlier!"
                ], 406);
                return 0;
            }

            echo $this->sendResponse([
                "user_id" => $userID,
                "squad_id" => $squadID,
                "message" => "You joined this squad :)"
            ],200);
        }
        return 0;
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


            echo $this->sendResponse($this->squadRepository->getSquadBySearch($decoded['search'], $userID),200);
        }
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

                echo $this->sendResponse([
                    "message" => "You have deleted this squad"
                ], 200);
                return 0;

            } else {

                echo $this->sendResponse([
                    "message" => "U are not admin, how did u get to this action? I'm calling the Police"
                ], 403);
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
}