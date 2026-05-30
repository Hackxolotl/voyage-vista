<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require "../db/db.php";
require "../auth/jwt.php";

$data = json_decode(
    file_get_contents("php://input"),
    true
);

$email = $data["email"] ?? "";
$password = $data["password"] ?? "";

$stmt = $pdo->prepare("
SELECT *
FROM utilisateurs
WHERE email = ?
");

$stmt->execute([$email]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {

    echo json_encode([
        "success" => false,
        "message" => "Utilisateur introuvable"
    ]);

    exit;
}

if (
    !password_verify(
        $password,
        $user["mot_de_passe"]
    )
) {

    echo json_encode([
        "success" => false,
        "message" => "Mot de passe incorrect"
    ]);

    exit;
}

$token = generateJWT($user);

echo json_encode([
    "success" => true,
    "token" => $token,
    "user" => [
        "id" => $user["id_utilisateur"],
        "nom" => $user["nom"],
        "prenom" => $user["prenom"],
        "role" => $user["role"],
        "est_etudiant" =>
            (bool)$user["est_etudiant"]
    ]
]);
