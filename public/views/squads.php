<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>SQUADS PAGE</title>
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
        <div class="messages">
            <?php if (isset($messages)) {
                foreach ($messages as $message) {
                    echo $message;
                }
            }
            ?>
        </div>
        <section class="squads">
            <?php require_once __DIR__ . '/../../src/repository/UserRepository.php';
            require_once __DIR__ . '/../../src/repository/SquadRepository.php';
            $userRepository = new UserRepository();
            $squadRepository = new SquadRepository();


            if($_COOKIE['user_token']!=null) {
                $currentUserID=$userRepository->cookieCheck($_COOKIE['user_token']);
                $currentUser = $userRepository->getUserUsingID($currentUserID);
            }
            foreach ($squads as $squad):
                $user = $userRepository->getUserUsingID($squad->getCreatorID());
                //BIORE ARRAY LUDZI ZE SQUADU, JESLI JEST WIEKSZY NIZ 5 TO OSTATNIE ZDJEICE ZAMIENIAM NA Zdjecie z liczbą
                // reszte zamieniam odpowiednio user[0].getPhoto(), user[1]/getPhoto() itd..
                $squadMembers = $squadRepository->getSquadMembers($squad->getID());
                ?>
                <div id="<?= $squad->getID(); ?>">
                    <div id="admin_buttons">
                        <? if ($currentUser!= null and $currentUser->getRole() === "admin"): ?>
                            <button class="squad-hyper delete_squad" >Delete squad</button>
                        <? endif; ?>
                    </div>
                    <div id="squad">
                        <img src="/public/img/uploads/<?= $user->getPhoto(); ?>">
                        <div id="squad_info">
                            <h2><?= $squad->getCreatorName(); ?></h2>
                            <p name="sport">Sport: <?= $squad->getSport(); ?></p>
                            <p name="max-members">Zawodników: <?= $squad->getMaxMembers(); ?></p>
                            <p name="fee">Opłata: <?= $squad->getFee(); ?> zł</p>
                            <p name="place"><?= $squad->getPlaceName(); ?></p>
                            <p name="address"><?= $squad->getAddress(); ?></p>
                            <p name="date"><?= $squad->getDate(); ?></p>

                            <button class="squad-hyper show_map">Show on map</button>
                        </div>
                    </div>
                    <div class="footer">
                        <h3>Squad</h3>
                        <div class="members">
                            <? $iter = 0;
                            while ($iter < 5) {
                                if ($squadMembers[$iter] == null) {
                                    break;
                                } ?>
                                <img src="/public/img/uploads/<?= $squadMembers[$iter]->getPhoto() ?>">
                                <? $iter++;
                                ?>
                            <? } ?>
                            <?php if (sizeof($squadMembers) > 5): ?>
                                <img src="/public/img/uploads/numbers/<?= sizeof($squadMembers) - 5 ?>.png">

                            <?php endif; ?>
                        </div>
                        <div class="decision">
                            <button class="squad-hyper text_organizer">Text organizer</button>
                            <button class="squad-hyper join_squad" id="<?= $squad->getID() ?>">Join
                                squad
                            </button>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
        </section>
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
