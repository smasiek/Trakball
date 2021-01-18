<?php

require_once 'AppController.php';

class DefaultController extends AppController
{

    public function login()
    {
        if ($this->cookieCheck() != 0) {
            return $this->render('squads');
        }
        return 0;
    }

    public function register()
    {
        if ($this->getCurrentUserID() == 0) {
            return $this->render('register');
        }else{
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/squads");
            return 0;
        }
    }

    public function squads()
    {
        if ($this->cookieCheck() != 0) {
            return $this->render('squads');
        }
        return 0;
    }

    public function new_squad()
    {
        if ($this->cookieCheck() != 0) {
            return $this->render('new_squad');
        }
        return 0;
    }

    public function your_places()
    {
        if ($this->cookieCheck() != 0) {
            return $this->render('your_places');
        }
        return 0;
    }

    public function your_squads()
    {
        if ($this->cookieCheck() != 0) {
            return $this->render('your_squads');
        }
        return 0;
    }

    public function settings()
    {
        if ($this->cookieCheck() != 0) {
            return $this->render('settings');
        }
        return 0;
    }


}