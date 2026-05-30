<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

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
