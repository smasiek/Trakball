<div class="members">
    <? $iter = 0;
    while ($iter < 5):
        if ($squadMembers[$iter] == null)
            break;?>
        <img src="/public/img/uploads/<?= $squadMembers[$iter]->getPhoto() ?>">
        <? $iter++; ?>
    <? endwhile; ?>
    <?php if (sizeof($squadMembers) > 5): ?>
        <img src="/public/img/uploads/numbers/<?= sizeof($squadMembers) - 5 ?>.png">

    <?php endif; ?>
</div>