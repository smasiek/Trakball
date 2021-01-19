<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Squads Page</title>
    <link rel="stylesheet" type="text/css" href="/public/css/style.css">
    <link rel="stylesheet" type="text/css" href="/public/css/squads.css">
    <script type="text/javascript" src="./public/js/search.js" defer></script>
    <script type="text/javascript" src="./public/js/joinSquad.js" defer></script>
    <script type="text/javascript" src="./public/js/deleteSquad.js" defer></script>
    <script type="text/javascript" src="./public/js/textOrganizer.js" defer></script>
    <script src="https://kit.fontawesome.com/346296466a.js" crossorigin="anonymous"></script>
</head>
<body>
<div class="base-container">
    <?php include('navigation_bar.php') ?>
    <main>
        <?php include('header.php') ?>
        <?php include('messages.php') ?>
        <?php include('squads_grid.php')?>
    </main>
</div>
</body>
</html>
<template id="squad-template">
    <div id="squad_id">
        <div id="admin_buttons">
        </div>
        <div id="squad">
            <img src="" id="creatorPhoto">
            <div id="squad_info">
                <h2>creator name</h2>
                <p name="sport">sport</p>
                <p name="max-members">members</p>
                <p name="fee">fee</p>
                <p name="place">place</p>
                <p name="address">address</p>
                <p name="date">date</p>
                <button class="squad-hyper show_map">Show on map</button>
            </div>
        </div>
        <div class="footer">
            <h3>Squad</h3>
            <div class="members">
            </div>
            <div class="decision">
                <button class="squad-hyper text_organizer">Text organizer</button>
                <button class="squad-hyper join_squad" id="id">Join squad</button>
            </div>
        </div>
    </div>
</template>
