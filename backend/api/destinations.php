<?php

require_once __DIR__ . "/../db.php";

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

$stmt = $pdo->query("SELECT * FROM destinations");

$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($data);
