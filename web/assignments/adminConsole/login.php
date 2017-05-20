<?php

require "auth.php";
require "dbConn.php";

$conn = getConn();

$email = $_REQUEST["email"];
$password = $_REQUEST["password"];

$arrayParams = checkPass($conn, $email, $password);
$valid = $arrayParams[0];
$adminId = $arrayParams[1];
if ($valid) {
    $token = insertSessionToken($conn, $email, $adminId);
    $validSession = validSession($conn, $token, $adminId);
    header("Location: /assignments/adminConsole/dashboard/?token=$token&userId=$adminId");
    die();
} else {
    header("Location: /assignments/adminConsole/");
    die();
}

?>