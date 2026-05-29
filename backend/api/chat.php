<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

$input = json_decode(file_get_contents("php://input"), true);
$message = $input["message"] ?? "";

$apiKey = getenv("GEMINI_API_KEY");
$model  = getenv("GEMINI_MODEL") ?: "gemini-3.1-flash-lite-preview";

/* 🔥 SYSTEM PROMPT EXTERNE */
$systemPrompt = file_get_contents(__DIR__ . "../prompts/system_prompt.txt");

$url = "https://generativelanguage.googleapis.com/v1beta/models/$model:generateContent?key=$apiKey";

$payload = [
  "contents" => [
    [
      "parts" => [
        ["text" => $systemPrompt . "\n\nUtilisateur: " . $message]
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

$response = file_get_contents($url, false, stream_context_create($options));
$data = json_decode($response, true);

echo json_encode([
  "reply" => $data["candidates"][0]["content"]["parts"][0]["text"] ?? "Erreur API"
]);
