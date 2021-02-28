<?php

$conn = mysqli_connect('localhost', 'cosmin_test', 'cosmin_test', 'atm_web');

if (!$conn) {
    echo "Connection error: " . mysqli_connect_error();
}

function checkLogin($email, $pass)
{
    global $conn;
    $stmt = $conn->prepare("select count(*) from users where email = ? and password = ?");
    $stmt->bind_param("ss", $email, $pass);
    $stmt->execute();
    $stmt->bind_result($login_result);
    $stmt->fetch();
    $stmt->close();
    return $login_result;
}

function getUserDetails($email)
{
    global $conn;
    $stmt = $conn->prepare("select id, first_name, last_name, '1234,72' balance from users where email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($userId, $firstName, $lastName, $balance);
    $stmt->fetch();
    $stmt->close();
    $userDetails = array($userId, $firstName, $lastName, $balance);
    return $userDetails;
}

function checkRegisterEmail($email)
{
    global $conn;
    $stmt = $conn->prepare("select count(*) from users where email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($email_exists);
    $stmt->fetch();
    $stmt->close();
    if ($email_exists > 0) {
        return true;
    } else {
        return false;
    }
}

function checkIban($iban)
{
    global $conn;
    $stmt = $conn->prepare("select count(*) from accounts where iban = ?");
    $stmt->bind_param("s", $iban);
    $stmt->execute();
    $stmt->bind_result($iban_exists);
    $stmt->fetch();
    $stmt->close();
    if ($iban_exists > 0) {
        return true;
    } else {
        return false;
    }
}

function registerUser($firstName, $lastName, $email, $password)
{
    global $conn;
    $stmt = $conn->prepare("insert into users(first_name, last_name, email, password) values(?, ?, ?, ?)");
    $stmt->bind_param("ssss", $firstName, $lastName, $email, $password);
    $stmt->execute();
    $stmt->close();
}

function getUserAccounts($userId)
{
    global $conn;
    $stmt = $conn->prepare("select ac.id, ac.iban, cu.code currency from accounts ac, currencies cu where ac.currency_id = cu.id and ac.user_id = ?");
    $stmt->bind_param("s", $userId);
    $stmt->execute();
    $stmt->bind_result($accountId, $iban, $currency);
    $accounts = array();
    while ($stmt->fetch()) {
        $account = array($accountId, $iban, $currency);
        array_push($accounts, $account);
    }
    $stmt->close();
    return $accounts;
}

function getAccountDetails($iban)
{
    global $conn;
    $stmt = $conn->prepare("select ac.id, ac.current_balance, ac.iban, cu.code from accounts ac, currencies cu where ac.currency_id = cu.id and ac.iban = ?");
    $stmt->bind_param("s", $iban);
    $stmt->execute();
    $stmt->bind_result($accountId, $balance, $qiban, $currency);
    $stmt->fetch();
    $stmt->close();
    $accountDetails = array($accountId, $balance, $qiban, $currency);
    return $accountDetails;
}


function getAvailableCurrencies($userId)
{
    global $conn;
    $stmt = $conn->prepare("select code from currencies where id not in (select currency_id from accounts where user_id = ?)");
    $stmt->bind_param("s", $userId);
    $stmt->execute();
    $stmt->bind_result($curName);
    $currencies = array();
    while ($stmt->fetch()) {
        array_push($currencies, $curName);
    }
    $stmt->close();
    return $currencies;
}

function getCurrencyId($currencyCode)
{
    global $conn;
    $stmt = $conn->prepare("select id from currencies where code = ?");
    $stmt->bind_param("s", $currencyCode);
    $stmt->execute();
    $stmt->bind_result($result);
    $stmt->fetch();
    $stmt->close();
    return $result;
}

function getAccountId($iban)
{
    global $conn;
    $stmt = $conn->prepare("select id from accounts where iban = ?");
    $stmt->bind_param("s", $iban);
    $stmt->execute();
    $stmt->bind_result($result);
    $stmt->fetch();
    $stmt->close();
    return $result;
}

function generateRandomString($length = 24)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function generateIban()
{
    global $conn;
    $generating = true;
    $generatedIban = "";
    while ($generating) {
        $newIban = generateRandomString(24);
        $stmt = $conn->prepare("select count(*) from accounts where iban = ?");
        $stmt->bind_param("s", $newIban);
        $stmt->execute();
        $stmt->bind_result($ibanExists);
        $stmt->fetch();
        $stmt->close();
        if ($ibanExists < 1) {
            $generating = false;
            $generatedIban = $newIban;
        }
    }
    return $generatedIban;
}

function openAccount($userId, $balance, $currencyCode)
{
    global $conn;

    $iban = generateIban();
    $currencyId = getCurrencyId($currencyCode);

    $stmt = $conn->prepare("insert into accounts(user_id, iban, current_balance, currency_id) values (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $userId, $iban, $balance, $currencyId);
    $stmt->execute();
    $stmt->fetch();
    $stmt->close();
}

function addBalance($iban, $balance)
{
    global $conn;

    $stmt = $conn->prepare("update accounts set current_balance = current_balance + ? where iban = ?");
    $stmt->bind_param("ss", $balance, $iban);
    $stmt->execute();
    $stmt->fetch();
    $stmt->close();

    $accountId = getAccountId($iban);
    $type = "ADD";

    $stmt = $conn->prepare("insert into transactions(from_account_id, value, type) values (?, ?, ?)");
    $stmt->bind_param("sss", $accountId, $balance, $type);
    $stmt->execute();
    $stmt->fetch();
    $stmt->close();
}

function withdraw($iban, $balance)
{
    global $conn;

    $stmt = $conn->prepare("update accounts set current_balance = current_balance - ? where iban = ?");
    $stmt->bind_param("ss", $balance, $iban);
    $stmt->execute();
    $stmt->fetch();
    $stmt->close();

    $accountId = getAccountId($iban);
    $type = "WITHDRAW";

    $stmt = $conn->prepare("insert into transactions(from_account_id, value, type) values (?, ?, ?)");
    $stmt->bind_param("sss", $accountId, $balance, $type);
    $stmt->execute();
    $stmt->fetch();
    $stmt->close();
}


function getTransactions($iban)
{
    global $conn;
    $stmt = $conn->prepare("select ac2.iban to_iban, t.value, t.date, t.type from transactions t left join accounts ac2 on t.to_account_id = ac2.id, accounts ac1 where t.from_account_id = ac1.id and ac1.iban = ?");
    $stmt->bind_param("s", $iban);
    $stmt->execute();
    $stmt->bind_result($to_iban, $value, $date, $type);
    $transactions = array();
    while ($stmt->fetch()) {
        $transaction = array($to_iban, $value, $date, $type);
        array_push($transactions, $transaction);
    }
    $stmt->close();
    return $transactions;
}

function transfer($from_iban, $to_iban, $value)
{
    global $conn;
    $stmt = $conn->prepare("update accounts set current_balance = current_balance - ? where iban = ?");
    $stmt->bind_param("ss", $value, $from_iban);
    $stmt->execute();
    $stmt->fetch();
    $stmt->close();

    $from_accountId = getAccountId($from_iban);
    $to_accountId = getAccountId($to_iban);
    $type = "TRANSFER_WITHDRAW";

    $stmt = $conn->prepare("insert into transactions(from_account_id, value, type, to_account_id) values (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $from_accountId, $value, $type, $to_accountId);
    $stmt->execute();
    $stmt->fetch();
    $stmt->close();

    global $conn;
    $stmt = $conn->prepare("update accounts set current_balance = current_balance + ? where iban = ?");
    $stmt->bind_param("ss", $value, $to_iban);
    $stmt->execute();
    $stmt->fetch();
    $stmt->close();

    $type = "TRANSFER_ADD";

    $stmt = $conn->prepare("insert into transactions(from_account_id, value, type, to_account_id) values (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $to_accountId, $value, $type, $from_accountId);
    $stmt->execute();
    $stmt->fetch();
    $stmt->close();
}
