<?php

$host = $_ENV["MYSQLHOST"];
$port = $_ENV["MYSQLPORT"];
$db   = $_ENV["MYSQLDATABASE"];
$user = $_ENV["MYSQLUSER"];
$pass = $_ENV["MYSQLPASSWORD"];

try {
    $pdo = new PDO(
        "mysql:host=$host;port=$port;dbname=$db;charset=utf8",
        $user,
        $pass
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {

    die(json_encode([
        "success" => false,
        "error" => $e->getMessage()
    ]));
}
