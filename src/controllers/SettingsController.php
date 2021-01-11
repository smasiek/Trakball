<?php

require_once 'AppController.php';
require_once __DIR__.'/../repository/UserRepository.php';

class SettingsController extends AppController
{
    const MAX_FILE_SIZE = 1024 * 1024;
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg'];
    const UPLOAD_DIRECTORY = '/../public/img/uploads/';

    private $messages = [];

    private $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository=new UserRepository();
    }

    public function edit_photo()
    {
        if ( $this->isPost() && is_uploaded_file($_FILES['file']['tmp_name']) && $this->validate($_FILES['file'])) {

            move_uploaded_file(
                $_FILES['file']['tmp_name'],
                dirname(__DIR__) . self::UPLOAD_DIRECTORY . $_FILES['file']['name']
            );

            $this->userRepository->setPhoto($_COOKIE['user_id'],$_FILES['file']['name']);
            return $this->render('settings', ['messages' => $this->messages,'image'=>$this->userRepository->getPhoto($_COOKIE['user_id'])]);

        }
        //For debugging purpose
        $this->render('squads', ['messages' => $this->messages]);
    }

    public function edit_data()
    {
        if ($this->isPost()) {

            $this->userRepository->editUserData($_COOKIE['user_id']);
            return $this->render('settings',  ['messages' => $this->messages,'image'=>$this->userRepository->getPhoto($_COOKIE['user_id'])]);
        }
        //For debugging purpose
        $this->render('squads', ['messages' => $this->messages]);
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

    public function settings(){

        if (isset($_COOKIE['user_id'])) {
            return $this->render('settings',['image'=>$this->userRepository->getPhoto($_COOKIE['user_id'])]);
        }

        $this->render('login');


        //$this->render('settings',['image'=>$this->userRepository->getImage($_COOKIE['user_email'])]);
    }

}


