<?php

require_once 'AppController.php';
require_once __DIR__ . '/../repository/UserRepository.php';
require_once __DIR__ . '/../models/User.php';

class SecurityController extends AppController
{
    public function login()
    {
        $userRepository = new UserRepository();

        if (!$this->isPost()) {
            if(isset($_COOKIE['user_email'])){
                return $this->render('squads');
            }
            return $this->render('login');
        }

        $email = $_POST["email"];
        $password = $_POST["password"];

        $user = $userRepository->getUser($email);

        if (!$user) {
            return $this->render('login', ['messages' => ['User does not exist!']]);
        }

        if ($user->getEmail() != $email) {
            return $this->render('login', ['messages' => ['User with this email does not exist!']]);
        }

        if ($user->getPassword() != $password) {
            return $this->render('login', ['messages' => ['Wrong password!']]);
        }

        //return $this->render('squads');

        setcookie("user_email", $user->getEmail(), time() + 3600, '/'); // expires after 1 hour)

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/squads");
    }
}