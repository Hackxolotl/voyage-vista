<?php
require "../db.php";

header("Content-Type: application/json");

try {
    $stmt = $pdo->query("SELECT * FROM packages");
    $packages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        "success" => true,
        "data" => $packages
    ]);

} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "error" => $e->getMessage()
    ]);
}
