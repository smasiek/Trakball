<?php

require_once 'AppController.php';

class SettingsController extends AppController
{
    const MAX_FILE_SIZE = 1024 * 1024;
    const SUPPORTED_TYPES = ['image/png', 'image/jpeg'];
    const UPLOAD_DIRECTORY = '/../public/uploads/';

    private $messages = [];

    public function edit_photo()
    {

        if ( $this->isPost() && is_uploaded_file($_FILES['file']['tmp_name']) && $this->validate($_FILES['file'])) {

            move_uploaded_file(
                $_FILES['file']['tmp_name'],
                dirname(__DIR__) . self::UPLOAD_DIRECTORY . $_FILES['file']['name']
            );



            return $this->render('settings', ['messages' => $this->messages]);
        }
        $this->render('squads', ['messages' => $this->messages]);
    }

    public function edit_data()
    {
        if ($this->isPost()) {


            return $this->render('settings', ['messages' => $this->messages]);
        }
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
}


