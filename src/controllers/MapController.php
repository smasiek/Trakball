<?php

require_once 'AppController.php';

class MapController extends AppController
{
    public function map()
    {

        $userID=$this->cookieCheck();
        if($userID!=0) {
            return $this->render('map');
        }
        return 0;
    }

}