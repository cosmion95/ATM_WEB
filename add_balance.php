<?php
session_start();
include('database.php');
$connectedUser = $_SESSION['connectedUser'];
$selectedAccount = $_SESSION['selectedAccount'];

$submitted = false;
$invalid_value = false;

$userDetails = getUserDetails($connectedUser);

if (isset($_POST['submit'])) {
    $submitted = true;

    if (($_POST['balance'] < 1) || empty($_POST['balance'])) {
        $invalid_value = true;
    } else {
        addBalance($selectedAccount, $_POST['balance']);
        header('Location: main_menu.php');
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link rel="stylesheet" href="styles/background.css">
    <link rel="stylesheet" href="styles/login.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <title>
        ATM - Add balance
    </title>
</head>

<body>
    <div class="login_background">
        <div class="logo_div">
            <div class="logo_text">
                Add balance
            </div>
            <form class="login_form" action="add_balance.php" method="POST" autocomplete="off">
                <input type="number" id="balance" name="balance" placeholder="Value"><br>
                <?php if ($submitted && $invalid_value) { ?>
                    <div class="error_msg">Invalid value.</div>
                <?php } ?>
                <br><br><input class="btn" type="submit" name="submit" value="Add">
            </form>
            <div class="btn cancel_btn">
                <a href="main_menu.php">Cancel</a>
            </div>
        </div>
    </div>
</body>

</html>