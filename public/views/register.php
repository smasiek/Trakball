<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" type="text/css" href="public/css/security.css">
    <script type="text/javascript" src="./public/js/registerValidationScript.js" defer></script>
    <title>Register Page</title>
</head>
<body>
    <div class="container">
        <div class="logo"></div>
        <div class="login-container">
            <form class="register" action="sign_up" method="POST">
                <?php include('messages.php')?>
                <input name="email" type="email" placeholder="email@email.com">
                <input name="password" type="password" placeholder="password">
                <input name="confirmedPassword" type="password" placeholder="confirm password">
                <input name="name" type="text" placeholder="name">
                <input name="surname" type="text" placeholder="surname">
                <input name="phone" type="text" placeholder="phone">
                <input name="date_of_birth" type="date" placeholder="date of birth">
                <button type="submit" class="sign" id="sign_up">sign up</button>
                <div class="tease-container">
                    <p name="tease">Click here to </p>
                    <a href="login"  class="sign-in"> sign in!</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>