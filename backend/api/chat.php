<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

// ======================
// INPUT
// ======================
$input = json_decode(file_get_contents("php://input"), true);
$message = $input["message"] ?? "";

if (!$message) {
  echo json_encode(["reply" => "Message vide"]);
  exit;
}

// ======================
// CONFIG
// ======================
$apiKey = getenv("GEMINI_API_KEY");
$model  = getenv("GEMINI_MODEL") ?: "gemini-3.1-flash-lite";

if (!$apiKey) {
  echo json_encode(["reply" => "API Key manquante"]);
  exit;
}

// ======================
// SYSTEM PROMPT
// ======================
$systemPath = __DIR__ . "/../prompts/system_prompt.txt";

if (!file_exists($systemPath)) {
  echo json_encode(["reply" => "System prompt introuvable"]);
  exit;
}

$systemPrompt = file_get_contents($systemPath);

// ======================
// GEMINI REQUEST
// ======================
$url = "https://generativelanguage.googleapis.com/v1beta/models/$model:generateContent?key=$apiKey";

$payload = [
  "systemInstruction" => [
    "parts" => [
      ["text" => $systemPrompt]
    ]
  ],
  "contents" => [
    [
      "role" => "user",
      "parts" => [
        ["text" => $message]
      ]
    ]
  ]
];

// ======================
// CURL CALL (ROBUST)
// ======================
$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
  "Content-Type: application/json"
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_TIMEOUT, 30);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);

curl_close($ch);

// ======================
// ERROR HANDLING
// ======================
if ($response === false) {
  echo json_encode([
    "reply" => "Erreur cURL",
    "error" => $error,
    "http" => $httpCode
  ]);
  exit;
}

// ======================
// DECODE RESPONSE
// ======================
$data = json_decode($response, true);

// Debug API error Gemini
if ($httpCode !== 200) {
  echo json_encode([
    "reply" => "Erreur API Gemini",
    "http" => $httpCode,
    "details" => $data
  ]);
  exit;
}

// ======================
// OUTPUT
// ======================
echo json_encode([
  "reply" => $data["candidates"][0]["content"]["parts"][0]["text"] ?? "Réponse vide"
]);
