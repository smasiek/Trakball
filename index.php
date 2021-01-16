<?php


require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'],'/');
$path = parse_url($path,PHP_URL_PATH);

Routing::get('', 'SquadsController');
Routing::get('squads', 'SquadsController');
Routing::get('new_squad', 'DefaultController');
Routing::get('your_squads', 'SquadsController');
Routing::get('your_places', 'DefaultController');
Routing::get('settings', 'SettingsController');
Routing::get('register', 'DefaultController');
Routing::get('log_out', 'SecurityController');

//TODO routing z squads do dodania uzytkownika do squadu

Routing::post('join_squad', 'SquadsController');
Routing::post('leave_squad', 'SquadsController');
Routing::post('sign_up', 'SecurityController');
Routing::post('edit_photo', 'SettingsController');
Routing::post('edit_data', 'SettingsController');
Routing::post('publish_squad', 'NewSquadController');
Routing::post('search', 'SquadsController');
Routing::post('login', 'SecurityController');
Routing::post('cities', 'NewSquadController');
Routing::get('delete_squad', 'SquadsController');


Routing::run($path);
