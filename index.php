<?php


require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'],'/');
$path = parse_url($path,PHP_URL_PATH);

Routing::get('', 'DefaultController');
Routing::get('squads', 'SquadsController');
Routing::get('new_squad', 'DefaultController');
Routing::get('your_squads', 'SquadsController');
Routing::get('your_places', 'DefaultController');
Routing::get('settings', 'SettingsController');
Routing::get('register', 'DefaultController');
Routing::get('sign_up', 'SecurityController');
Routing::get('edit_photo', 'SettingsController');
Routing::get('edit_data', 'SettingsController');
Routing::get('publish_squad', 'NewSquadController');
Routing::get('log_out', 'SecurityController');

Routing::post('login', 'SecurityController');
Routing::run($path);
