<?php
    require_once __DIR__ . '/../connect_db.php';

    class PieceRepository {
        private $pdo;

        public function __construct() {
            $this->pdo = connectDB();
        }

        /**
         * Récupère toutes les pièces d'un chantier
         * @param int $chantier_id ID du chantier
         * @return array Liste des pièces avec leurs infos
         */
        public function getPiecesByChantier($chantier_id) {
            $stmt = $this->pdo->prepare("
                SELECT
                    p.id, p.nom, p.etage, p.degre_finition, p.type_piece_id,
                    tp.libelle AS type_piece,
                    COUNT(t.id) AS total_taches,
                    SUM(CASE WHEN t.statut = 'Terminé' THEN 1 ELSE 0 END) AS taches_terminees
                FROM Piece p
                JOIN TypePiece tp ON p.type_piece_id = tp.id
                LEFT JOIN Tache t ON p.id = t.piece_id
                WHERE p.chantier_id = :chantier_id
                GROUP BY p.id
                ORDER BY p.etage, tp.libelle, p.nom
            ");
            $stmt->bindParam(':chantier_id', $chantier_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        /**
         * Récupère une pièce par son ID
         * @param int $piece_id ID de la pièce
         * @return array|null Informations de la pièce ou null si non trouvée
         */
        public function getPieceById($piece_id) {
            $stmt = $this->pdo->prepare("
                SELECT p.*, tp.libelle AS type_piece
                FROM Piece p
                JOIN TypePiece tp ON p.type_piece_id = tp.id
                WHERE p.id = :piece_id
            ");
            $stmt->bindParam(':piece_id', $piece_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        /**
         * Ajoute une nouvelle pièce à un chantier
         * @param array $data Données de la pièce
         * @return bool True si succès, false sinon
         */
        public function addPiece($data) {
            try {
                $stmt = $this->pdo->prepare("
                    INSERT INTO Piece
                    (chantier_id, type_piece_id, nom, etage, degre_finition)
                    VALUES (:chantier_id, :type_piece_id, :nom, :etage, :degre_finition)
                ");
                return $stmt->execute($data);
            } catch (PDOException $e) {
                error_log("Erreur PieceRepository::addPiece: " . $e->getMessage());
                return false;
            }
        }

        /**
         * Met à jour une pièce existante
         * @param int $piece_id ID de la pièce
         * @param array $data Données à mettre à jour
         * @return bool True si succès, false sinon
         */
        public function updatePiece($piece_id, $data) {
            try {
                $data[':piece_id'] = $piece_id;
                $stmt = $this->pdo->prepare("
                    UPDATE Piece SET
                        type_piece_id = :type_piece_id,
                        nom = :nom,
                        etage = :etage,
                        degre_finition = :degre_finition
                    WHERE id = :piece_id
                ");
                return $stmt->execute($data);
            } catch (PDOException $e) {
                error_log("Erreur PieceRepository::updatePiece: " . $e->getMessage());
                return false;
            }
        }

        /**
         * Supprime une pièce
         * @param int $piece_id ID de la pièce
         * @return bool True si succès, false sinon
         */
        public function deletePiece($piece_id) {
            try {
                // Supprimer d'abord les tâches associées
                $this->pdo->prepare("DELETE FROM Tache WHERE piece_id = :piece_id")
                        ->execute([':piece_id' => $piece_id]);

                // Puis supprimer la pièce
                $stmt = $this->pdo->prepare("DELETE FROM Piece WHERE id = :piece_id");
                return $stmt->execute([':piece_id' => $piece_id]);
            } catch (PDOException $e) {
                error_log("Erreur PieceRepository::deletePiece: " . $e->getMessage());
                return false;
            }
        }

        /**
         * Récupère les types de pièces disponibles
         * @return array Liste des types de pièces
         */
        public function getTypesPiece() {
            return $this->pdo->query("SELECT id, libelle FROM TypePiece ORDER BY libelle")
                            ->fetchAll(PDO::FETCH_ASSOC);
        }

        /**
         * Récupère les éléments d'une pièce
         * @param int $piece_id ID de la pièce
         * @return array Liste des éléments avec leurs catégories
         */
        public function getElementsByPiece($piece_id) {
            $stmt = $this->pdo->prepare("
                SELECT e.id, e.libelle, e.categorie_id, ce.libelle AS categorie
                FROM ElementDansPiece edp
                JOIN Element e ON edp.element_id = e.id
                JOIN CategorieElement ce ON e.categorie_id = ce.id
                WHERE edp.piece_id = :piece_id
                ORDER BY ce.libelle, e.libelle
            ");
            $stmt->bindParam(':piece_id', $piece_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        /**
         * Ajoute un élément à une pièce
         * @param int $piece_id ID de la pièce
         * @param int $element_id ID de l'élément
         * @return bool True si succès, false sinon
         */
        public function addElementToPiece($piece_id, $element_id) {
            try {
                // Vérifier si l'élément existe déjà
                $stmt = $this->pdo->prepare("
                    SELECT COUNT(*) FROM ElementDansPiece
                    WHERE piece_id = :piece_id AND element_id = :element_id
                ");
                $stmt->bindParam(':piece_id', $piece_id, PDO::PARAM_INT);
                $stmt->bindParam(':element_id', $element_id, PDO::PARAM_INT);
                $stmt->execute();

                if ($stmt->fetchColumn() > 0) {
                    return true; // Déjà présent, pas besoin d'ajouter
                }

                // Ajouter l'élément
                $stmt = $this->pdo->prepare("
                    INSERT INTO ElementDansPiece (piece_id, element_id)
                    VALUES (:piece_id, :element_id)
                ");
                return $stmt->execute([
                    ':piece_id' => $piece_id,
                    ':element_id' => $element_id
                ]);
            } catch (PDOException $e) {
                error_log("Erreur PieceRepository::addElementToPiece: " . $e->getMessage());
                return false;
            }
        }

        /**
         * Supprime un élément d'une pièce
         * @param int $piece_id ID de la pièce
         * @param int $element_id ID de l'élément
         * @return bool True si succès, false sinon
         */
        public function removeElementFromPiece($piece_id, $element_id) {
            try {
                $stmt = $this->pdo->prepare("
                    DELETE FROM ElementDansPiece
                    WHERE piece_id = :piece_id AND element_id = :element_id
                ");
                return $stmt->execute([
                    ':piece_id' => $piece_id,
                    ':element_id' => $element_id
                ]);
            } catch (PDOException $e) {
                error_log("Erreur PieceRepository::removeElementFromPiece: " . $e->getMessage());
                return false;
            }
        }

        /**
         * Calcule l'avancement d'une pièce
         * @param int $piece_id ID de la pièce
         * @return array ['total' => int, 'terminees' => int, 'pourcentage' => float]
         */
        public function getAvancementPiece($piece_id) {
            $stmt = $this->pdo->prepare("
                SELECT
                    COUNT(*) AS total,
                    SUM(CASE WHEN statut = 'Terminé' THEN 1 ELSE 0 END) AS terminees
                FROM Tache
                WHERE piece_id = :piece_id
            ");
            $stmt->bindParam(':piece_id', $piece_id, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            $result['pourcentage'] = $result['total'] > 0 ?
                round(($result['terminees'] / $result['total']) * 100) : 0;

            return $result;
        }
    }
?>
