<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

$input = json_decode(file_get_contents("php://input"), true);
$message = $input["message"] ?? "";

$apiKey = getenv("GEMINI_API_KEY");

$url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=$apiKey";

$data = [
  "contents" => [
    [
      "parts" => [
        ["text" => $message]
      ]
    ]
  ]
];

$options = [
  "http" => [
    "header" => "Content-Type: application/json",
    "method" => "POST",
    "content" => json_encode($data)
  ]
];

$context = stream_context_create($options);
$response = file_get_contents($url, false, $context);

$result = json_decode($response, true);

echo json_encode([
  "reply" => $result["candidates"][0]["content"]["parts"][0]["text"] ?? "Erreur API"
]);
