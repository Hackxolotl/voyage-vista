<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require "../db/db.php";

$data = json_decode(
    file_get_contents("php://input"),
    true
);

$nom = trim($data["nom"] ?? "");
$prenom = trim($data["prenom"] ?? "");
$email = trim($data["email"] ?? "");
$password = $data["password"] ?? "";

$estEtudiant = (
    $data["est_etudiant"] ?? false
) ? 1 : 0;

if (
    !$nom ||
    !$prenom ||
    !$email ||
    !$password
) {
    http_response_code(400);

    echo json_encode([
        "success" => false,
        "message" => "Champs manquants"
    ]);

    exit;
}

$stmt = $pdo->prepare("
SELECT id_utilisateur
FROM utilisateurs
WHERE email = ?
");

$stmt->execute([$email]);

if ($stmt->fetch()) {

    echo json_encode([
        "success" => false,
        "message" => "Email déjà utilisé"
    ]);

    exit;
}

$hash = password_hash(
    $password,
    PASSWORD_DEFAULT
);

$stmt = $pdo->prepare("
INSERT INTO utilisateurs
(
nom,
prenom,
email,
mot_de_passe,
role,
est_etudiant
)
VALUES (?, ?, ?, ?, 'user', ?)
");

$stmt->execute([
    $nom,
    $prenom,
    $email,
    $hash,
    $estEtudiant
]);

echo json_encode([
    "success" => true
]);
