<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require "../auth/auth.php";

try {

    $user = getAuthenticatedUser();

    if (!$user) {

        http_response_code(401);

        echo json_encode([
            "success" => false,
            "message" => "Non authentifié"
        ]);

        exit;
    }

    echo json_encode([
        "success" => true,
        "user" => [
            "id" => $user->id,
            "email" => $user->email,
            "role" => $user->role,
            "est_etudiant" => $user->est_etudiant,
            "iat" => $user->iat ?? null,
            "exp" => $user->exp ?? null
        ]
    ]);

} catch (Throwable $e) {

    http_response_code(500);

    echo json_encode([
        "success" => false,
        "message" => "Erreur serveur",
        "error" => $e->getMessage()
    ]);
}
