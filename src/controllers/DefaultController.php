<?php

require_once 'AppController.php';

class DefaultController extends AppController
{

    public function login()
    {
        //TODO display login.php
        if (isset($_COOKIE['user_id'])) {
            return $this->render('squads');
        }
        $this->render('login');
    }

    public function register()
    {
        //TODO display login.php
        $this->render('register');
    }

    public function squads()
    {
        //TODO display squads.php
        if (isset($_COOKIE['user_id'])) {
            return $this->render('squads');
        }

        $this->render('login');
    }

    public function new_squad()
    {
        //TODO display squads.php
        if (isset($_COOKIE['user_id'])) {
            return $this->render('new_squad');
        }

        $this->render('login');
    }

    public function your_places()
    {
        //TODO display squads.php
        if (isset($_COOKIE['user_id'])) {
            return $this->render('your_places');
        }

        $this->render('login');
    }

    public function your_squads()
    {
        //TODO display squads.php
        if (isset($_COOKIE['user_id'])) {
            return $this->render('your_squads');
        }

        $this->render('login');
    }

    public function settings()
    {
        //TODO display squads.php
        if (isset($_COOKIE['user_id'])) {
            return $this->render('settings');
        }

        $this->render('login');
    }


}