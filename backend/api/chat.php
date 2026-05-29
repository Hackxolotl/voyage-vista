<?php
header("Content-Type: text/event-stream");
header("Cache-Control: no-cache");
header("Connection: keep-alive");
header("Access-Control-Allow-Origin: *");

$input = json_decode(file_get_contents("php://input"), true);
$message = $input["message"] ?? "";

$apiKey = getenv("GEMINI_API_KEY");
$model  = getenv("GEMINI_MODEL") ?: "gemini-3.1-flash-lite-preview";

$url = "https://generativelanguage.googleapis.com/v1beta/models/$model:streamGenerateContent?key=$apiKey";

$payload = [
  "contents" => [
    [
      "parts" => [
        ["text" => $message]
      ]
    ]
  ]
];

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_HTTPHEADER, [
  "Content-Type: application/json"
]);

curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_WRITEFUNCTION, function($ch, $chunk) {

  // Gemini envoie du JSON chunké → on stream direct au frontend
  echo "data: " . trim($chunk) . "\n\n";
  ob_flush();
  flush();

  return strlen($chunk);
});

curl_exec($ch);
curl_close($ch);

echo "data: [DONE]\n\n";
