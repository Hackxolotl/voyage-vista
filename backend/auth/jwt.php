<?php

require __DIR__ . '/../vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function generateJWT($user)
{
    $payload = [
        "id" => $user["id_utilisateur"],
        "email" => $user["email"],
        "role" => $user["role"],
        "est_etudiant" => (bool)$user["est_etudiant"],
        "iat" => time(),
        "exp" => time() + 60 * 60 * 24 * 7
    ];

    return JWT::encode(
        $payload,
        getenv("JWT_SECRET"),
        "HS256"
    );
}

function verifyJWT($token)
{
    return JWT::decode(
        $token,
        new Key(
            getenv("JWT_SECRET"),
            "HS256"
        )
    );
}
