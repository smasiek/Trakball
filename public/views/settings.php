<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SQUADS PAGE</title>
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <link rel="stylesheet" type="text/css" href="public/css/settings.css">
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
            <div class="edit_photo">
                <img src="public/img/uploads/meme2.jpg">
                <form action="edit_photo" method="POST" ENCTYPE="multipart/form-data">
                    <?php if(isset($messages)){
                        foreach ($messages as $message){
                            echo $message;
                        }
                    }
                    ?>
                    <input type="file" name="file">
                    <button id="edit_photo_button" type="submit">edit photo</button>
                </form>

            </div>
            <form class="edit_data_form" action="edit_data" method="POST" ENCTYPE="multipart/form-data">
                <?php if(isset($messages)){
                    foreach ($messages as $message){
                        echo $message;
                    }
                }
                ?>
                <input name="email" placeholder="email" type="email">

                <input name="password_1" placeholder="password" type="password">

                <input name="password_2" placeholder="repeat password" type="password">

                <input name="name" placeholder="name">

                <input name="surname" placeholder="surname">

                <input name="date_of_birth" placeholder="date of birth" type="date">

                <button id="edit" type="submit">edit</button>
            </form>

        </div>

    </main>
</div>
</body>
</html>