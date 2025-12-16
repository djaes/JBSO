<?php
// tests/Unit/Repository/TypePieceRepositoryTest.php
namespace Tests\Unit\Repository;

use PHPUnit\Framework\TestCase;
use JBSO\Repository\TypePieceRepository;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Statement;

class TypePieceRepositoryTest extends TestCase
{
    public function testFindAll()
    {
        // Créer un mock de la connexion
        $connection = $this->createMock(Connection::class);

        // Configurer le mock de la connexion pour retourner des résultats
        $connection->method('fetchAllAssociative')
            ->willReturn([
                ['id' => 1, 'label' => 'Salon'],
                ['id' => 2, 'label' => 'Cuisine']
            ]);

        // Créer une instance du repository avec le mock de la connexion
        $repository = new TypePieceRepository();
        $reflection = new \ReflectionClass($repository);
        $property = $reflection->getProperty('connection');
        $property->setAccessible(true);
        $property->setValue($repository, $connection);

        // Appeler la méthode à tester
        $results = $repository->findAll();

        // Vérifier les résultats
        $this->assertCount(2, $results);
        $this->assertEquals('Salon', $results[0]->getLabel());
        $this->assertEquals('Cuisine', $results[1]->getLabel());
    }
}
