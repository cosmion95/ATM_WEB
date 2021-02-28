<?php
session_start();
include('database.php');
$connectedUser = $_SESSION['connectedUser'];
$selectedAccount = $_SESSION['selectedAccount'];

$userDetails = getUserDetails($connectedUser);
$transactions = getTransactions($selectedAccount);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/background.css">
    <link rel="stylesheet" href="styles/history.css">
    <title>
        ATM - Transactions
    </title>
</head>

<body>
    <div class="login_background">
        <div class="history_div">
            <table id="T2">
                <tr>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Value</th>
                    <th>To</th>
                </tr>
                <?php
                foreach ($transactions as $transaction) {
                    echo "<tr>";
                    echo "<td>" . $transaction[2] . "</td>";
                    echo "<td>" . $transaction[3] . "</td>";
                    echo "<td>" . $transaction[1] . "</td>";
                    echo "<td>" . $transaction[0] . "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
            <div class="back_button_div">
                <a href="main_menu.php"><button class="btn" type="button">Back</button></a>
            </div>
        </div>
    </div>
</body>

</html>