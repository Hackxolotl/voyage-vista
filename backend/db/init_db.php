<?php
require "db.php";

/* 🔐 SECRET KEY depuis les variables d'environnement */
$SECRET_KEY = getenv("INIT_DB_SECRET");

/* fonction d'exécution SQL */
function runSQLFile($pdo, $filePath) {
    if (!file_exists($filePath)) {
        die("File not found: " . $filePath);
    }

    $sql = file_get_contents($filePath);

    try {
        $pdo->exec($sql);
        echo "Executed: " . $filePath . "<br>";
    } catch (Exception $e) {
        echo "Error in " . $filePath . ": " . $e->getMessage() . "<br>";
    }
}

/* 🔐 SECURITY CHECK */
if (!isset($_GET["key"]) || !$SECRET_KEY || $_GET["key"] !== $SECRET_KEY) {
    http_response_code(403);
    die("❌ Unauthorized");
}

/* 🚀 EXECUTION */
runSQLFile($pdo, "init.sql");

echo "✅ DONE";
