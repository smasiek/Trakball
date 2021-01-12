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
    <?php include('navigation_bar.php')?>
    <main>
        <?php include('header.php')?>

        <div class="main_content">
            <div class="edit_photo">

                <img src="public/img/uploads/<?=$image?>">
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