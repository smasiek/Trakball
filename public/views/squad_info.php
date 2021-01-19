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


    </div>
    <button class="squad-hyper show_map">Show on map</button>
</div>