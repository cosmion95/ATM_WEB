<?php
session_start();
include('database.php');
$connectedUser = $_SESSION['connectedUser'];
$selectedAccount = $_SESSION['selectedAccount'];

$userDetails = getUserDetails($connectedUser);
$accountDetails = getAccountDetails($selectedAccount);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/background.css">
    <link rel="stylesheet" href="styles/main_menu.css">
    <title>
        ATM - Main Menu
    </title>
</head>

<body>
    <div class="menu_background">
        <div class="main_menu_div">
            <div>
                <h1><?php echo $userDetails[1] . ", your account balance is: " . $accountDetails[1] . " " . $accountDetails[3]; ?></h1>
            </div>
            <ul class="ul_menu">
                <li><a href="add_balance.php">Add</a></li>
                <li><a href="withdraw.php">Withdraw</a></li>
                <li><a href="transfer.php">Transfer</a></li>
                <li><a href="history.php">History</a></li>
                <li><a href="accounts.php">Choose another account</a></li>
                <li><a href="index.php">Logout</a></li>
            </ul>
        </div>
    </div>
</body>

</html>