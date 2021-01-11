<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>SQUADS PAGE</title>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <link rel="stylesheet" type="text/css" href="public/css/squads.css">
    <script type="text/javascript" src="./public/js/search.js" defer></script>
    <!-- <script type="text/javascript" src="./public/js/joinSquad.js" defer></script> -->
    <script src="https://kit.fontawesome.com/346296466a.js" crossorigin="anonymous"></script>
</head>
<body>
<div class="base-container">
    <nav>
        <img src="public/img/Logo small.png">
        <ul>
            <li>
                <i class="fas fa-map-marked-alt"></i>
                <a href="<?= "http://$_SERVER[HTTP_HOST]/map" ?>" class="button">map</a>
            </li>
            <li>
                <i class="fas fa-user-plus"></i>
                <a href="squads" class="button">squads</a>
            </li>
            <li>
                <i class="fas fa-map-marker-alt"></i>
                <a href="your_places" class="button">your places</a>
            </li>
            <li>
                <i class="fas fa-user-friends"></i>
                <a href="your_squads" class="button">your squads</a>
            </li>
            <li name="sign-in">
                <i class="fas fa-user-alt"></i>
                <a href="" class="button">sign in</a>
            </li>
            <li name="log-out">
                <i class="fas fa-user-alt-slash"></i>
                <a href="log_out" class="button">log out</a>
            </li>
            <li>
                <i class="fas fa-cog"></i>
                <a href="settings" class="button">settings</a>
            </li>
        </ul>
    </nav>
    <main>
        <header>
            <div class="search-bar">
                <input placeholder="search squad" id="search-bar">
            </div>

            <div class="add-squad" onclick="location.href='new_squad'">
                <i class="fas fa-plus"></i>
                add squad
            </div>
        </header>
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

            foreach ($squads as $squad){
                $user = $userRepository->getUserUsingID($squad->getCreatorID());
                //BIORE ARRAY LUDZI ZE SQUADU, JESLI JEST WIEKSZY NIZ 5 TO OSTATNIE ZDJEICE ZAMIENIAM NA Zdjecie z liczbą
                // reszte zamieniam odpowiednio user[0].getPhoto(), user[1]/getPhoto() itd..
                $squadMembers = $squadRepository->getSquadMembers($squad->getID());

                ?>
                <div id="<?= $squad->getID(); ?>">
                    <img src="public/img/uploads/<?= $user->getPhoto() ;?>">
                    <h2><?= $squad->getCreatorName(); ?></h2>
                    <p name="sport">Sport: <?= $squad->getSport(); ?></p>
                    <p name="max-members">Zawodników: <?= $squad->getMaxMembers(); ?></p>
                    <p name="fee">Opłata: <?= $squad->getFee(); ?> zł</p>
                    <p name="place"><?= $squad->getPlaceName(); ?></p>
                    <p name="address"><?= $squad->getAddress(); ?></p>
                    <p name="date"><?= $squad->getDate(); ?></p>
                    <a href="#" class="squad-hyper">Show on map</a>
                    <div class="footer">
                        <h3>Squad</h3>
                        <div class="members">
                            <? $iter = 0;
                            while ($iter < 5){
                                if ($squadMembers[$iter] == null) {
                                    break;
                                } ?>
                                <img src="public/img/uploads/<?= $squadMembers[$iter]->getPhoto() ?>">
                                <? $iter++;
                                ?>
                            <?}?>
                            <?php if (sizeof($squadMembers) > 5): ?>
                                <img src="public/img/uploads/numbers/<?= sizeof($squadMembers) - 5 ?>.png">

                            <?php endif; ?>
                        </div>
                        <div class="decision">
                            <a href="#" class="squad-hyper" id="text_organizator">Text organizator</a>
                            <a href="join_squad/<?= $squad->getID() ?>" class="squad-hyper" id="join_squad">Join
                                squad</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </section>
    </main>
</div>
</body>
</html>
<template id="squad-template">
    <div id="squad1">
        <img src="" id="creatorPhoto">
        <h2>creator name</h2>
        <p name="sport">sport</p>
        <p name="max-members">members</p>
        <p name="fee">fee</p>
        <p name="place">place</p>
        <p name="address">address</p>
        <p name="date">date</p>
        <a href="#" class="squad-hyper">Show on map</a>
        <div class="footer">
            <h3>Squad</h3>
            <div class="members">
                <img src="">
                <img src="">
                <img src="">
                <img src="">
                <img src="">
            </div>
            <div class="decision">
                <a href="#" class="squad-hyper">Text organizator</a>
                <a href="" class="squad-hyper">Join squad</a>
            </div>
        </div>
    </div>
</template>
