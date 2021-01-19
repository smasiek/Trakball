<section class="squads">
    <?php require_once __DIR__ . '/../../src/repository/UserRepository.php';
    require_once __DIR__ . '/../../src/repository/SquadRepository.php';
    $userRepository = new UserRepository();
    $squadRepository = new SquadRepository();

    if ($_COOKIE['user_token'] != null) {
        $currentUserID = $userRepository->cookieCheck($_COOKIE['user_token']);
        $currentUser = $userRepository->getUserUsingID($currentUserID);
    }

    foreach ($squads as $squad):
        $user = $userRepository->getUserUsingID($squad->getCreatorID());
        $squadMembers = $squadRepository->getSquadMembers($squad->getID());
        ?>
        <div id="<?= $squad->getID(); ?>">
            <div id="admin_buttons">
                <? if ($currentUser != null and $currentUser->getRole() === "admin"): ?>
                    <button class="squad-hyper delete_squad">Delete squad</button>
                <? endif; ?>
            </div>
            <?php include('squad_info.php') ?>
            <div class="footer">
                <h3>Squad</h3>
                <?php include('members.php') ?>
                <div class="decision">
                    <button class="squad-hyper text_organizer">Text organizer</button>
                    <?php
                    if($_SERVER['REQUEST_URI']==="/your_squads"):?>
                        <a href="leave_squad/<?= $squad->getID() ?>" class="squad-hyper">Leave squad</a>
                    <?else:?>
                        <button class="squad-hyper join_squad" id="<?= $squad->getID() ?>">Join
                            squad
                        </button>
                    <?endif;?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</section>