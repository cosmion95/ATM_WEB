<?php
session_start();
include('database.php');
$connectedUser = $_SESSION['connectedUser'];

$userDetails = getUserDetails($connectedUser);

$availableCurrencies = getAvailableCurrencies($userDetails[0]);

if (empty($availableCurrencies)){
    header('Location: accounts.php?no_currency_available');
}

if (isset($_POST['submit'])) {
    openAccount($userDetails[0], $_POST['balance'], $_POST['selected_currency']);
    header('Location: accounts.php?account_created');
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
        ATM - Add new account
    </title>
</head>

<body>
    <div class="login_background">
        <div class="logo_div">
            <div class="logo_text">
                Open new account
            </div>
            <form class="login_form" action="new_account.php" method="POST" autocomplete="off">
                <input type="number" id="balance" name="balance" placeholder="Balance"><br>

                <div class="input-field">
                    <select class="browser-default" name="selected_currency" id="selected_currency">;
                        <?php
                        foreach ($availableCurrencies as $currency) {
                            echo "<option value=\"" . $currency . "\">" . $currency . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <br><br><input class="btn" type="submit" name="submit" value="Open account">
            </form>
            <div class="btn cancel_btn">
                <a href="accounts.php">Cancel</a>
            </div>
        </div>
    </div>
</body>

</html>