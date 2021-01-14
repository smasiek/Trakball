<head>
    <script type="text/javascript" src="./public/js/responsiveNaviBar.js" defer></script>
    <script type="text/javascript" src="./public/js/logoClickHandling.js" defer></script>
</head>
<nav>
    <div class="navbar_images">
         <img src="/public/img/Logo small.png" class="logo_small">
        <label for="show-menu" class="show-menu"><img src="/public/img/hamburger.png" id="hamburger" alt="menu"></label>
        <input type="checkbox" id="show-menu" role="button">
    </div>
    <ul id="menu">
        <li>
            <i class="fas fa-map-marked-alt"></i>
            <a href="<?= "http://$_SERVER[HTTP_HOST]/map" ?>" class="button">map</a>
        </li>
        <li>
            <i class="fas fa-user-plus"></i>
            <a href="<?= "http://$_SERVER[HTTP_HOST]/squads" ?>" class="button">squads</a>
        </li>
        <li>
            <i class="fas fa-map-marker-alt"></i>
            <a href="<?= "http://$_SERVER[HTTP_HOST]/your_places" ?>" class="button">your places</a>
        </li>
        <li>
            <i class="fas fa-user-friends"></i>
            <a href="<?= "http://$_SERVER[HTTP_HOST]/your_squads" ?>" class="button">your squads</a>
        </li>

        <?
        if ($_COOKIE['user_id'] == null):
            ?>
        <li name="sign-in">
            <i class="fas fa-user-alt"></i>
            <a href="<?= "http://$_SERVER[HTTP_HOST]/login" ?>" class="button">sign in</a>
        </li>
        <?else:?>
        <li name="log-out">
            <i class="fas fa-user-alt-slash"></i>
            <a href="<?= "http://$_SERVER[HTTP_HOST]/log_out" ?>" class="button">log out</a>
        </li>
        <li name="settings">
            <i class="fas fa-cog"></i>
            <a href="<?= "http://$_SERVER[HTTP_HOST]/settings" ?>" class="button">settings</a>
        </li>
        <?endif;?>
    </ul>
</nav>