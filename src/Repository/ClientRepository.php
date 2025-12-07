<?php
namespace JBSO\Repository;

use JBSO\Entity\Client;
use JBSO\Database\Connection;

class ClientRepository
{
    public function save(Client $client): int
    {
        $conn = Connection::getConnection();

        if ($client->getId() === null) {
            // Insertion
            $sql = "INSERT INTO Client (nom, adresse, telephone, email) VALUES (:nom, :adresse, :telephone, :email)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                'nom' => $client->getNom(),
                'adresse' => $client->getAdresse(),
                'telephone' => $client->getTelephone(),
                'email' => $client->getEmail()
            ]);
            $client->setId($conn->lastInsertId());
        } else {
            // Mise à jour
            $sql = "UPDATE Client SET nom = :nom, adresse = :adresse, telephone = :telephone, email = :email WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                'nom' => $client->getNom(),
                'adresse' => $client->getAdresse(),
                'telephone' => $client->getTelephone(),
                'email' => $client->getEmail(),
                'id' => $client->getId()
            ]);
        }

        return $client->getId();
    }

    public function findById(int $id): ?Client
    {
        $conn = Connection::getConnection();
        $sql = "SELECT * FROM Client WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetchAssociative();

        if (!$row) {
            return null;
        }

        $client = new Client();
        $client->setId($row['id']);
        $client->setNom($row['nom']);
        $client->setAdresse($row['adresse']);
        $client->setTelephone($row['telephone']);
        $client->setEmail($row['email']);

        return $client;
    }

    public function findAll(): array
    {
        $conn = Connection::getConnection();
        $sql = "SELECT * FROM Client";
        $stmt = $conn->query($sql);

        $clients = [];
        while ($row = $stmt->fetchAssociative()) {
            $client = new Client();
            $client->setId($row['id']);
            $client->setNom($row['nom']);
            $client->setAdresse($row['adresse']);
            $client->setTelephone($row['telephone']);
            $client->setEmail($row['email']);
            $clients[] = $client;
        }

        return $clients;
    }

    public function delete(int $id): bool
    {
        $conn = Connection::getConnection();
        $sql = "DELETE FROM Client WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute(['id' => $id]);

        return $result;
    }
}
