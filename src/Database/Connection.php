<?php
// src/Database/Connection.php

namespace JBSO\Database;

use Doctrine\DBAL\DriverManager;
use Dotenv\Dotenv;
use Dotenv\Exception\InvalidPathException;

class Connection
{
    private static $connection = null;

    public static function getConnection(): \Doctrine\DBAL\Connection
    {
        if (self::$connection === null) {
            try {
                // Charger .env
                $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
                $dotenv->load();

                // Vérifier que toutes les variables sont définies
                $requiredEnvVars = ['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_PASSWORD', 'DB_DRIVER'];
                foreach ($requiredEnvVars as $var) {
                    if (empty($_ENV[$var])) {
                        throw new \RuntimeException("La variable d'environnement $var n'est pas définie.");
                    }
                }

                // Configurer la connexion
                $connectionParams = [
                'dbname' => $_ENV['DB_NAME'],// Nom de ta base de données
                'user' => $_ENV['DB_USER'],// Utilisateur MySQL
                'password' => $_ENV['DB_PASSWORD'],// Mot de passe MySQL
                'host' => $_ENV['DB_HOST'],// Hôte de la base de données
                'driver' => $_ENV['DB_DRIVER'],// Driver PDO pour MySQL
            ];

                self::$connection = DriverManager::getConnection($connectionParams);
            } catch (InvalidPathException $e) {
                throw new \RuntimeException("Fichier .env introuvable. Copie .env.example en .env et configure-le.");
            } catch (\Exception $e) {
                throw new \RuntimeException("Erreur de connexion à la base de données : " . $e->getMessage());
            }
        }
        return self::$connection;
    }
}
?>