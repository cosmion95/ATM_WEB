<?php
session_start();
include('database.php');

$found = false;
$submitted = false;

if (isset($_POST['submit'])) {
    $submitted = true;
    $login_result = checkLogin($_POST['email'], $_POST['pass']);
    if ($login_result > 0) {
        $found = true;
        $_SESSION['connectedUser'] = $_POST['email'];
        header('Location: accounts.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="styles/background.css">
    <link rel="stylesheet" href="styles/login.css">

    <script type="text/javascript" src="scripts/login.js"></script>
    <title>
        ATM - Log In
    </title>
</head>

<body>
    <div class="login_background">
        <div class="logo_div">
            <?php if (isset($_GET['register_complete'])) { ?>
                <div class="register_complete">Registration complete. Please log in.</div>
            <?php } ?>
            <div class="logo_text">
                ATM
            </div>
            <form class="login_form" action="index.php" method="POST" autocomplete="off">
                <input type="text" id="email" name="email" placeholder="Email"><br>
                <div id="email_field_msg_id" class="empty_field_msg"></div>
                <input type="password" id="pass" name="pass" placeholder="Password">
                <div class="empty_field_msg"></div>
                <br><br><input class="btn" type="submit" name="submit" value="Log in" onclick="checkEmailField()">
            </form>
            <?php if ($submitted && !$found) { ?>
                <div class="wrong_user_msg">Wrong username or password.</div>
            <?php } ?>
            <div class="btn register_btn">
                <a href="register.php">Register</a>
            </div>
            <div><a href="reset_password.php">Forgot password?</a></div>
        </div>
    </div>
</body>

</html>