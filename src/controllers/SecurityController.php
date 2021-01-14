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
            if (isset($_COOKIE['user_id'])) {
                return $this->render('squads');
            }
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

        if(password_verify($password, $user->getPassword())) {
            setcookie("user_id", $user->getId(), time() + 3600, '/'); // expires after 1 hour)

            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/squads");

        }
        return $this->render('login', ['messages' => ['Wrong password!']]);

    }

    public function sign_up()
    {
        $userRepository = new UserRepository();

        $email = $_POST["email"];
        $password = $_POST["password"];
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

        $hashedPassword=password_hash($password,PASSWORD_DEFAULT);

        if ($userRepository->newUser($email, $hashedPassword, $name, $surname, $phone, $date_of_birth)) {
            return $this->render('login', ['messages' => ['You can Sign in!']]);
        } else {
            return $this->render('register', ['messages' => ['Something went wrong!']]);
        }
        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/squads");
    }

    public function log_out(){
        setcookie('user_id', null, -1, '/');
        //setcookie('user_id', $_COOKIE['user_id'], -1, '/');
        $this->render('login');
    }
}