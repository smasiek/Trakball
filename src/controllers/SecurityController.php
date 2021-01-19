<?php

require_once 'AppController.php';
require_once __DIR__ . '/../repository/UserRepository.php';
require_once __DIR__ . '/../models/User.php';

class SecurityController extends AppController
{
    public function login()
    {
        if ($this->getCurrentUserID() == 0) {
            $userRepository = new UserRepository();

            if (!$this->isPost()) {
                return $this->render('login');
            }

            $email = $_POST["email"];
            $password = $_POST["password"];

            $user = $userRepository->getUserUsingEmail($email);

            if (!$user) {
                return $this->render('login', ['messages' => ['User does not exist!']]);
            }

            if ($user->getEmail() != $email) {
                return $this->render('login', ['messages' => ['User with this email does not exist!']]);
            }


            if (password_verify($password, $user->getPassword())) {

                $this->setCookie($user->getId(), uniqid());

                $url = "http://$_SERVER[HTTP_HOST]";
                header("Location: {$url}/squads");

                return 0;

            }

            return $this->render('login', ['messages' => ['Wrong password!']]);
        } else {

            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/squads");
            return 0;
        }


    }

    public function sign_up()
    {
        $userRepository = new UserRepository();

        $email = $_POST["email"];
        $password = $_POST["password"];
        $confirmedPassword = $_POST["confirmedPassword"];
        $name = $_POST["name"];
        $surname = $_POST["surname"];
        $phone = $_POST["phone"];
        $date_of_birth = $_POST["date_of_birth"];

        $user = $userRepository->getUserUsingEmail($email);

        if ($user != null) {
            return $this->render('register', ['messages' => ['User with this email already exists!']]);
        }

        if ($email == null) {
            return $this->render('register', ['messages' => ['You have to enter email!']]);
        }
        if ($password == null) {
            return $this->render('register', ['messages' => ['You have to enter password!']]);
        }
        if ($confirmedPassword == null) {
            return $this->render('register', ['messages' => ['You have to confirm password!']]);
        }
        if ($name == null) {
            return $this->render('register', ['messages' => ['You have to enter name!']]);
        }
        if ($surname == null) {
            return $this->render('register', ['messages' => ['You have to enter surname!']]);
        }
        if ($phone == null) {
            return $this->render('register', ['messages' => ['You have to enter phone!']]);
        }
        if ($date_of_birth == null) {
            return $this->render('register', ['messages' => ['You have to enter date_of_birth!']]);
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        if ($userRepository->newUser($email, $hashedPassword, $name, $surname, $phone, $date_of_birth)) {
            return $this->render('login', ['messages' => ['You can Sign in!']]);
        } else {
            return $this->render('register', ['messages' => ['Something went wrong!']]);
        }
    }

    public function log_out()
    {
        $currID=$this->getCurrentUserID();
        if($currID==0){
            return $this->render('login', ['messages' => ["You're session expired"]]);
        }
        return $this->render('login', ['messages' => [$this->unsetCookie($_COOKIE['user_token'])]]);
    }
}