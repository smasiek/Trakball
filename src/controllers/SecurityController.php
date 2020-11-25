<?php

require_once 'AppController.php';
require_once __DIR__ . '/../models/User.php';

class SecurityController extends AppController
{
    public function login()
    {
        $user = new User('admin@admin.pl', 'admin', 'Janek', 'Dzbanek');

        if($this->isPost()){
            //return $this->login('login');  tak zrobil w filmiku Pan Adrian
            return $this->render('login');
        }

        $email = $_POST["email"];
        $password = $_POST["password"];

        if ($user->getEmail() != $email) {
            return $this->render('login', ['messages' => ['User with this email does not exist!']]);
        }

        if ($user->getPassword() != $password) {
            return $this->render('login', ['messages' => ['Wrong password!']]);
        }

        //return $this->render('squads');

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/squads");
    }
}