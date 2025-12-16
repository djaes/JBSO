<?php
// tests/Unit/Database/ConnectionTest.php
namespace Tests\Unit\Database;

use PHPUnit\Framework\TestCase;
use JBSO\Database\Connection;
use Dotenv\Dotenv;
use Dotenv\Exception\InvalidPathException;

class ConnectionTest extends TestCase
{
    public function testGetConnectionSuccess()
    {
        // Sauvegarde les variables d'environnement actuelles
        $originalEnv = $_ENV;

        // Simule un environnement de test avec des variables d'environnement valides
        $_ENV['DB_HOST'] = 'localhost';
        $_ENV['DB_NAME'] = 'JBSOrganiseur';
        $_ENV['DB_USER'] = 'admin_JBSO';
        $_ENV['DB_PASSWORD'] = '231280';
        $_ENV['DB_DRIVER'] = 'pdo_mysql';

        // Teste la connexion
        $connection = Connection::getConnection();
        $this->assertInstanceOf(\Doctrine\DBAL\Connection::class, $connection);

        // Restaure les variables d'environnement originales
        $_ENV = $originalEnv;
    }

    public function testGetConnectionMissingEnvVariables()
    {
        // Sauvegarde les variables d'environnement actuelles
        $originalEnv = $_ENV;

        // Supprime une variable d'environnement requise
        unset($_ENV['DB_HOST']);

        // Vérifie qu'une exception est levée
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage("La variable d'environnement DB_HOST n'est pas définie.");
        Connection::getConnection();

        // Restaure les variables d'environnement originales
        $_ENV = $originalEnv;
    }

    public function testGetConnectionInvalidEnvFile()
    {
        // Sauvegarde les variables d'environnement actuelles
        $originalEnv = $_ENV;

        // Simule un fichier .env introuvable
        $connection = $this->getMockBuilder(Connection::class)
                            ->disableOriginalConstructor()
                            ->onlyMethods(['loadEnv'])
                            ->getMock();

        $connection->expects($this->once())
                   ->method('loadEnv')
                   ->willThrowException(new InvalidPathException("Fichier .env introuvable."));

        // Vérifie qu'une exception est levée
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage("Fichier .env introuvable. Copie .env.example en .env et configure-le.");
        $connection->getConnection();

        // Restaure les variables d'environnement originales
        $_ENV = $originalEnv;
    }
}
