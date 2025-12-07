<?php
// fonctions/gestion_chantier/ChantierRepository.php
require_once __DIR__ . '/../connect_db.php';

class ChantierRepository {
    private $pdo;

    public function __construct() {
        $this->pdo = connectDB();
    }

    /**
     * Récupère tous les chantiers avec filtres
     */
    public function getAllChantiers($search = '', $degre = '', $date_debut = '', $date_fin = '') {
        $sql = "
            SELECT c.id, c.nom, c.client, c.adresse, c.degre_finition_global, c.date_creation,
                   COUNT(p.id) AS nb_pieces,
                   SUM(CASE WHEN t.statut = 'Terminé' THEN 1 ELSE 0 END) AS taches_terminees,
                   COUNT(t.id) AS total_taches
            FROM Chantier c
            LEFT JOIN Piece p ON c.id = p.chantier_id
            LEFT JOIN Tache t ON p.id = t.piece_id
        ";

        $conditions = [];
        $params = [];

        if (!empty($search)) {
            $conditions[] = "c.nom LIKE :search";
            $params[':search'] = "%$search%";
        }

        if (!empty($degre)) {
            $conditions[] = "c.degre_finition_global = :degre";
            $params[':degre'] = $degre;
        }

        if (!empty($date_debut)) {
            $conditions[] = "DATE(c.date_creation) >= :date_debut";
            $params[':date_debut'] = $date_debut;
        }

        if (!empty($date_fin)) {
            $conditions[] = "DATE(c.date_creation) <= :date_fin";
            $params[':date_fin'] = $date_fin;
        }

        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $sql .= " GROUP BY c.id ORDER BY c.date_creation DESC";

        $stmt = $this->pdo->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère les degrés de finition disponibles
     */
    public function getDegresFinition() {
        return $this->pdo->query("
            SELECT DISTINCT degre_finition_global
            FROM Chantier
            ORDER BY
                CASE degre_finition_global
                    WHEN 'Économique' THEN 1
                    WHEN 'Standard' THEN 2
                    WHEN 'Soignée' THEN 3
                END
        ")->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Ajoute un nouveau chantier
     */
    public function addChantier($data) {
        $stmt = $this->pdo->prepare("
            INSERT INTO Chantier
            (nom, client, adresse, degre_finition_global, date_debut, date_fin, date_creation)
            VALUES (:nom, :client, :adresse, :degre, :date_debut, :date_fin, NOW())
        ");
        return $stmt->execute($data);
    }

    /**
     * Récupère un chantier par son ID
     */
    public function getChantierById($id) {
        $stmt = $this->pdo->prepare("
            SELECT * FROM Chantier WHERE id = :id
        ");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ... autres méthodes (update, delete, etc.)
}
?>
