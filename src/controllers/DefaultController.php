<?php

require_once  'AppController.php';

class DefaultController extends AppController {

    public function login(){
        //TODO display login.php
        $this->render('login');
    }

    public function register(){
    //TODO display login.php
    $this->render('register');
}

    public function  squads(){
        //TODO display squads.php
        $this->render('squads');
    }

    public function  new_squad(){
        //TODO display squads.php
        $this->render('new_squad');
    }

    public function  your_places(){
        //TODO display squads.php
        $this->render('your_places');
    }

    public function  your_squads(){
        //TODO display squads.php
        $this->render('your_squads');
    }

    public function  settings(){
        //TODO display squads.php
        $this->render('settings');
    }


}