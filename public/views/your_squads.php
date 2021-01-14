<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SQUADS PAGE</title>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <link rel="stylesheet" type="text/css" href="public/css/squads.css">
    <script src="https://kit.fontawesome.com/346296466a.js" crossorigin="anonymous"></script>
</head>
<body>
<div class="base-container">
    <?php include('navigation_bar.php')?>
    <main>
        <?php include('header.php')?>
        <section class="squads">
            <?php require_once __DIR__ . '/../../src/repository/UserRepository.php';
            require_once __DIR__ . '/../../src/repository/SquadRepository.php';
            $userRepository = new UserRepository();
            $squadRepository = new SquadRepository();

            foreach ($squads as $squad):{
                $user = $userRepository->getUserUsingID($squad->getCreatorID());
                $squadMembers = $squadRepository->getSquadMembers($squad->getID());}
                ?>
                <div id="<?= $squad->getID(); ?>">

                    <!--TODO POPRAWIC STRUKTURE BY DOBRZE SIE WYSWIETLAL CSS-->

                    <img src="public/img/uploads/<?= $user->getPhoto() ?>">
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
                            while ($iter < 5):
                                if ($squadMembers[$iter] == null) {
                                    break;
                                } ?>
                                <img src="public/img/uploads/<?= $squadMembers[$iter]->getPhoto() ?>">
                                <? $iter++;
                                ?>
                            <? endwhile; ?>
                            <?php if (sizeof($squadMembers) > 5): ?>
                                <img src="public/img/uploads/numbers/<?= sizeof($squadMembers) - 5 ?>.png">

                            <?php endif; ?>
                        </div>
                        <div class="decision">
                            <a href="#" class="squad-hyper" id="text_organizator">Text organizator</a>
                            <a href="leave_squad/<?= $squad->getID() ?>" class="squad-hyper">Leave squad</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>
    </main>
</div>
</body>
</html>