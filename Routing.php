<?php

require_once 'src/controllers/DefaultController.php';
require_once 'src/controllers/SecurityController.php';
require_once 'src/controllers/SettingsController.php';
require_once 'src/controllers/NewSquadController.php';
require_once 'src/controllers/SquadsController.php';
require_once 'src/controllers/MapController.php';

class Routing {
    public static $routes;

    public static function get($url,$controller){
        self::$routes[$url]=$controller;
    }

    public static function post($url,$controller){
        self::$routes[$url]=$controller;
    }

    public static function run($url){
        $urlParts = explode("/", $url);
        $action = $urlParts[0];

        if (!array_key_exists($action, self::$routes)) {
            die("Wrong url!");
        }

        $controller = self::$routes[$action];
        $object = new $controller;
        $action = $action ?: 'squads';

        $id = $urlParts[1] ?? '';

        $object->$action($id);
    }
}