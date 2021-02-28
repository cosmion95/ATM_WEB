<?php
session_start();
include('database.php');
$connectedUser = $_SESSION['connectedUser'];

$userDetails = getUserDetails($connectedUser);
$accounts = getUserAccounts($userDetails[0]);

if (isset($_GET['selected_account'])) {
    $_SESSION['selectedAccount'] = $_GET['selected_account'];
    header('Location: main_menu.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/background.css">
    <link rel="stylesheet" href="styles/accounts.css">
    <title>
        ATM - Choose account
    </title>
</head>

<body>
    <div class="menu_background">
        <div class="main_menu_div">
            <div>
                <h1><?php echo "Welcome, " . $userDetails[1]; ?></h1>
            </div>
            <?php if (isset($_GET['account_created'])) { ?>
                <div class="account_created">New account has been opened.</div>
            <?php } ?>
            <?php if (isset($_GET['no_currency_available'])) { ?>
                <div class="no_currency_available">No other currencies are available. You cannot open new accounts.</div>
            <?php } ?>
            <div>
                <h3>
                    <?php
                     if (empty($accounts)){
                        echo "You do not have any opened accounts.";
                     }
                     else {
                        echo "Select your account:";
                     }
                    ?>
                </h3>
            </div>
            <ul class="ul_accounts">
                <?php foreach ($accounts as $account) {
                    echo "<li>";
                        echo "<li><a href=\"accounts.php?selected_account=$account[1]\">";
                            echo $account[1] . " - " . $account[2];
                        echo "</a></li>"; }
                ?>
            </ul>
            <ul class="ul_options">
                <li><a href="new_account.php">Open new account</a></li>
                <li><a href="index.php">Logout</a></li>
            </ul>
        </div>
    </div>
</body>

</html>