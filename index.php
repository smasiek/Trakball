<?php


require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'],'/');
$path = parse_url($path,PHP_URL_PATH);

Routing::get('', 'DefaultController');
Routing::get('squads', 'DefaultController');
Routing::get('new_squad', 'DefaultController');
Routing::get('your_squads', 'DefaultController');
Routing::get('your_places', 'DefaultController');
Routing::get('settings', 'SettingsController');
Routing::get('register', 'DefaultController');
Routing::get('edit_photo', 'SettingsController');
Routing::get('edit_data', 'SettingsController');
Routing::get('publish_squad', 'NewSquadController');

Routing::post('login', 'SecurityController');
Routing::run($path);
