<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="public/css/security.css">
    <script type="text/javascript" src="./public/js/logoClickHandling.js" defer></script>
    <title>Login Page</title>
</head>
<body>
    <div class="container">
        <div class="logo"></div>
        <div class="login-container">
            <form class="login" action="login" method="POST">
                <?php include('messages.php')?>
                <input name="email" type="email" placeholder="email@email.com">
                <input name="password" type="password" placeholder="password">
                <button type="submit" class="sign">sign in</button>
                <div class="tease-container">
                    <p name="tease">Click here to </p>
                    <a href="<?"http://$_SERVER[HTTP_HOST]"?>register" class="sign-up"> sign up!</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>