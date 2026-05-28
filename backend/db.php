<?php

$host = getenv("DB_HOST") ?: "db";
$db   = getenv("DB_NAME") ?: "voyagevista";
$user = getenv("DB_USER") ?: "user";
$pass = getenv("DB_PASSWORD") ?: "password";

try {

  $pdo = new PDO(
    "mysql:host=$host;dbname=$db;charset=utf8",
    $user,
    $pass
  );

} catch (Exception $e) {

  die(json_encode([
    "success" => false,
    "error" => $e->getMessage()
  ]));
}
