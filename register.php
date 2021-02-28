<?php
session_start();
include('database.php');

$found = false;
$errorRegister = false;

if (isset($_POST['submit'])) {

    $emailExists = checkRegisterEmail($_POST['email']);
    if (!$emailExists) {
        registerUser($_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['pass1']);
        header('Location: index.php?register_complete');
    } else {
        $errorRegister = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="styles/background.css">
    <link rel="stylesheet" href="styles/register.css">
    <title>
        ATM - Register
    </title>
</head>

<body>
    <div class="login_background">
        <div class="logo_div">
            <div class="logo_text">
                ATM
            </div>
            <form class="register_form" action="register.php" method="POST" autocomplete="off">
                <input type="text" id="firstname" name="firstname" placeholder="First name"><br>
                <input type="text" id="lastname" name="lastname" placeholder="Last name"><br>
                <input type="text" id="email" name="email" placeholder="Email"><br>
                <?php if ($errorRegister) { ?>
                    <div class="wrong_user_msg">A user with this email already exists.</div>
                <?php } ?>
                <input type="password" id="pass1" name="pass1" placeholder="Password"><br>
                <input type="password" id="pass2" name="pass2" placeholder="Confirm password"><br>
                <input class="btn register_btn" type="submit" name="submit" value="Register">
            </form>
            <div class="btn cancel_register_btn">
                <a href="index.php">Cancel</a>
            </div>
        </div>
    </div>
</body>

</html>