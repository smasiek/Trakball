<?php

require_once __DIR__ . '/../../Database.php';

class Repository
{
    protected $database;

    public function __construct()
    {
        $this->database = new Database();
    }

    protected function cookieCheck()
    {
        if (!isset($_COOKIE['user_id'])) {
            $this->render('login');
        }
    }
}