<?php

try {

    $pdo = new PDO(
        "mysql:host=" . $_ENV["MYSQLHOST"] .
        ";port=" . $_ENV["MYSQLPORT"] .
        ";dbname=" . $_ENV["MYSQLDATABASE"],
        $_ENV["MYSQLUSER"],
        $_ENV["MYSQLPASSWORD"]
    );

    echo json_encode([
        "success" => true,
        "message" => "Database connected"
    ]);

} catch(PDOException $e) {

    echo json_encode([
        "success" => false,
        "error" => $e->getMessage()
    ]);
}
