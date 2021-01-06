<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="public/css/style.css">
    <title>LOGIN PAGE</title>
</head>
<body>
    <div class="container">
        <div class="logo"></div>
        <div class="login-container">
            <form class="login" action="sign_up" method="POST">
                <div class="messages">
                    <?php if(isset($messages)){
                        foreach ($messages as $message){
                            echo $message;
                        }
                    }
                    ?>
                </div>
                <input name="email" type="email" placeholder="email@email.com">
                <input name="password" type="password" placeholder="password">
                <input name="name" type="text" placeholder="name">
                <input name="surname" type="text" placeholder="surname">
                <input name="phone" type="text" placeholder="phone">
                <input name="date_of_birth" type="date" placeholder="date of birth">
                <button type="submit" class="sign">sign up</button>
                <div class="tease-container">
                    <p name="tease">Click here to </p>
                    <a href="<?"http://$_SERVER[HTTP_HOST]"?>login"  class="sign-in"> sign in!</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>