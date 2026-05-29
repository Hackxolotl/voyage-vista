<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

$input = json_decode(file_get_contents("php://input"), true);
$message = $input["message"] ?? "";

$apiKey = getenv("GEMINI_API_KEY");
$model  = getenv("GEMINI_MODEL") ?: "gemini-3.1-flash-lite-preview";

$url = "https://generativelanguage.googleapis.com/v1beta/models/$model:generateContent?key=$apiKey";

$payload = [
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
    "header"  => "Content-Type: application/json",
    "method"  => "POST",
    "content" => json_encode($payload)
  ]
];

$context = stream_context_create($options);
$response = file_get_contents($url, false, $context);

if ($response === false) {
  echo json_encode(["error" => "Gemini request failed"]);
  exit;
}

$data = json_decode($response, true);

echo json_encode([
  "reply" => $data["candidates"][0]["content"]["parts"][0]["text"] ?? "No response"
]);
