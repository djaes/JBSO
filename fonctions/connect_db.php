<?php
function connectDB() {
    static $pdo = null; // Stockage en cache pour éviter de recréer la connexion

    if ($pdo === null) {
        $env = parse_ini_file(__DIR__ . '/../.env');
        $dsn = "mysql:host={$env['DB_HOST']};dbname={$env['DB_NAME']};charset=utf8mb4";
        try {
            $pdo = new PDO($dsn, $env['DB_USER'], $env['DB_PASS'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données: " . $e->getMessage());
        }
    }
    return $pdo;
}
?>

