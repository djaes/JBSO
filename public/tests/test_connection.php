<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../../vendor/autoload.php';

use JBSO\Database\Connection;

try {
    $connection = Connection::getConnection();
    echo "<h2>Connexion à la base de données réussie !</h2>";
    echo "<p>Version du serveur MySQL : " . $connection->fetchOne("SELECT VERSION()") . "</p>";
    echo "<p>Base de données utilisée : " . $_ENV['DB_NAME'] . "</p>";
    echo "<form action='test_generic_repository.php' method='get'><button type='submit'>Tester le GenericRepository</button></form>";
} catch (\Exception $e) {
    echo "<h2>Erreur de connexion à la base de données</h2>";
    echo "<p>" . $e->getMessage() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?>
