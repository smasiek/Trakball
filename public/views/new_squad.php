<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SQUADS PAGE</title>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <link rel="stylesheet" type="text/css" href="public/css/new_squad.css">
    <script src="https://kit.fontawesome.com/346296466a.js" crossorigin="anonymous"></script>
</head>
<body>
<div class="base-container">
    <nav>
        <img src="public/img/Logo small.png">
        <ul>
            <li>
                <i class="fas fa-map-marked-alt"></i>
                <a href="#" class="button">map</a>
            </li>
            <li>
                <i class="fas fa-user-plus"></i>
                <a href="#" class="button">squads</a>
            </li>
            <li>
                <i class="fas fa-map-marker-alt"></i>
                <a href="#" class="button">your places</a>
            </li>
            <li>
                <i class="fas fa-user-friends"></i>
                <a href="#" class="button">your squads</a>
            </li>
            <li name="sign-in">
                <i class="fas fa-user-alt"></i>
                <a href="#" class="button">sign in</a>
            </li>
            <li name="log-out">
                <i class="fas fa-user-alt-slash"></i>
                <a href="#" class="button">log out</a>
            </li>
            <li>
                <i class="fas fa-cog"></i>
                <a href="#" class="button">settings</a>
            </li>
        </ul>
    </nav>
    <main>
        <header>
            <div class="search-bar">
                <form>
                    <input placeholder="search project">
                </form>
            </div>

            <div class="add-squad">
                <i class="fas fa-plus"></i>
                add squad
            </div>
        </header>

        <div class="main_content">
            <form class="new_squad_form">
                <input list="cities" name="city" placeholder="City">
                <datalist id="cities">
                    <option value ="Kraków"></option>
                    <option value ="Warszawa"></option>
                </datalist>

                <input list="streets" name="street" placeholder="Street">
                <datalist id="streets">
                    <option value ="Nowa Huta 15"></option>
                    <option value ="Kamienna"></option>
                </datalist>

                <input list="names" name="name" placeholder="Place name">
                <datalist id="names">
                    <option value ="Comcom zone"></option>
                    <option value ="Hala Politechniki Krakowskiej"></option>
                </datalist>

                <input list="sports" name="sport" placeholder="Sport">
                <datalist id="sports">
                    <option value ="Piłka nożna"></option>
                    <option value ="Koszykówka"></option>
                    <option value ="Siatkówka"></option>
                    <option value ="Piłka ręczna"></option>
                    <option value ="Tenis"></option>
                    <option value ="Hokej"></option>
                </datalist>

                <input list="players" name="max_players" placeholder="Max numer of players">
                <datalist id="players">
                    <option value ="1"></option>
                    <option value ="2"></option>
                    <option value ="3"></option>
                    <option value ="4"></option>
                    <option value ="5"></option>
                    <option value ="6"></option>
                </datalist>

                <input name="fee" type="text" placeholder="Entry fee">

                <button id="publish">publish</button>
            </form>
            <img class="ball_logo" src="public/img/Logo.png">
        </div>

    </main>
</div>
</body>
</html>