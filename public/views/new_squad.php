<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SQUADS PAGE</title>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <link rel="stylesheet" type="text/css" href="public/css/new_squad.css">
    <script type="text/javascript" src="./public/js/dynamicSuggestion.js" defer></script>
    <script src="https://kit.fontawesome.com/346296466a.js" crossorigin="anonymous"></script>
</head>
<body>
<div class="base-container">
    <?php include('navigation_bar.php')?>
    <main>
        <?php include('header.php')?>
        <div class="main_content">
            <form class="new_squad_form" action="publish_squad" method="POST">
                <div class="messages">
                    <?php if(isset($messages)){
                        foreach ($messages as $message){
                            echo $message;
                        }
                    }
                    ?>
                </div>
                <input list="cities" class="city" placeholder="City">
                <datalist id="cities">
                </datalist>

                <input list="streets" class="street" placeholder="Street">
                <datalist id="streets">
                </datalist>

                <input list="names" class="name" placeholder="Place name">
                <datalist id="names">
                </datalist>

                <input list="sports" class="sport" placeholder="Sport">
                <datalist id="sports">
                    <option value ="Piłka nożna"></option>
                    <option value ="Koszykówka"></option>
                    <option value ="Siatkówka"></option>
                    <option value ="Piłka ręczna"></option>
                    <option value ="Tenis"></option>
                    <option value ="Hokej"></option>
                </datalist>

                <input type="number" min="1" max="30" class="max_players" placeholder="Max numer of players">

                <input class="fee" type="text" placeholder="Entry fee">

                <input class="date" type="datetime-local">
                <!-- TODO zrobic zabezpieczenie przed dodaniem daty wczesnieszej niz dzis-->

                <button id="publish" type="submit">publish</button>
            </form>
            <img class="ball_logo" src="public/img/Logo.png">
        </div>

    </main>
</div>
</body>
</html>