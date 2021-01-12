<nav>
    <img src="public/img/Logo small.png">
    <ul>
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
        <li name="sign-in">
            <i class="fas fa-user-alt"></i>
            <a href="" class="button">sign in</a>
        </li>
        <li name="log-out">
            <i class="fas fa-user-alt-slash"></i>
            <a href="<?= "http://$_SERVER[HTTP_HOST]/log_out" ?>" class="button">log out</a>
        </li>
        <li>
            <i class="fas fa-cog"></i>
            <a href="<?= "http://$_SERVER[HTTP_HOST]/settings" ?>" class="button">settings</a>
        </li>
    </ul>
</nav>