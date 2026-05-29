<?php
header("Content-Type: application/json");

$input = json_decode(file_get_contents("php://input"), true);
$message = $input["message"] ?? "";

echo json_encode([
    "reply" => "Tu as dit : " . $message
]);
