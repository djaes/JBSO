<?php
require_once __DIR__ . '/../connect_db.php';

class TacheGenerator {
    /**
     * Génère toutes les tâches pour un chantier.
     */
    public static function genererTachesPourChantier($chantier_id) {
        $pdo = connectDB();

        
        // Vérifier si des tâches existent déjà pour ce chantier
        $exists = $pdo->prepare("SELECT COUNT(*) FROM Tache WHERE chantier_id = :chantier_id");
        $exists->bindParam(':chantier_id', $chantier_id, PDO::PARAM_INT);
        $exists->execute();

        // Si aucune tâche n'existe, générer les tâches
        if ($exists->fetchColumn() == 0) {
            // 1. Récupérer les pièces du chantier
            $pieces = $pdo->prepare("
                SELECT id, degre_finition, type_piece_id
                FROM Piece
                WHERE chantier_id = :chantier_id
            ");
            $pieces->bindParam(':chantier_id', $chantier_id, PDO::PARAM_INT);
            $pieces->execute();

            foreach ($pieces->fetchAll() as $piece) {
                self::genererTachesPourPiece($chantier_id, $piece['id'], $piece['degre_finition']);
            }
        }
    }

    /**
     * Génère les tâches pour une pièce spécifique.
     */
    public static function genererTachesPourPiece($chantier_id, $piece_id, $degre_finition) {
        $pdo = connectDB();

        // 2. Récupérer les éléments de la pièce
        $elements = $pdo->prepare("
            SELECT e.id, e.libelle, e.categorie_id, c.libelle AS categorie
            FROM ElementDansPiece edp
            JOIN Element e ON edp.element_id = e.id
            JOIN CategorieElement c ON e.categorie_id = c.id
            WHERE edp.piece_id = :piece_id
        ");
        $elements->bindParam(':piece_id', $piece_id, PDO::PARAM_INT);
        $elements->execute();
        $elements = $elements->fetchAll(PDO::FETCH_ASSOC);

        // 3. Récupérer les étapes dans l'ordre
        $etapes = $pdo->query("SELECT id, libelle, ordre FROM EtapeTravail ORDER BY ordre")->fetchAll();

        foreach ($etapes as $etape) {
            // 4. Récupérer les types de tâches applicables
            $tachesType = $pdo->prepare("
                SELECT id, libelle, degre_finition_min
                FROM TacheType
                WHERE etape_id = :etape_id
            ");
            $tachesType->bindParam(':etape_id', $etape['id'], PDO::PARAM_INT);
            $tachesType->execute();

            foreach ($tachesType->fetchAll() as $tacheType) {
                // Vérifier si le degré de finition est suffisant
                if (self::degreEstSuffisant($degre_finition, $tacheType['degre_finition_min'])) {
                    foreach ($elements as $element) {
                        if (self::tacheApplicable($tacheType['libelle'], $element['categorie'])) {
                            // 5. Ajouter la tâche
                            $pdo->prepare("
                                INSERT IGNORE INTO Tache
                                (chantier_id, piece_id, element_id, tache_type_id, ordre, statut)
                                VALUES (:chantier_id, :piece_id, :element_id, :tache_type_id, :ordre, 'À faire')
                            ")->execute([
                                ':chantier_id' => $chantier_id,
                                ':piece_id' => $piece_id,
                                ':element_id' => $element['id'],
                                ':tache_type_id' => $tacheType['id'],
                                ':ordre' => $etape['ordre']
                            ]);
                        }
                    }
                }
            }
        }
    }

    /**
     * Vérifie si le degré de finition est suffisant.
     */
    private static function degreEstSuffisant($degre_piece, $degre_min) {
        $hierarchie = ['Économique' => 1, 'Standard' => 2, 'Soignée' => 3];
        return $hierarchie[$degre_piece] >= $hierarchie[$degre_min];
    }

    /**
     * Vérifie si la tâche s'applique à la catégorie de l'élément.
     */
    private static function tacheApplicable($tache_libelle, $categorie) {
        $masquageMots = ['masquage', 'protection', 'démontage'];
        $peintureMots = ['ponçage', 'couche', 'impression', 'revision', 'application'];

        if ($categorie === 'À masquer') {
            foreach ($masquageMots as $mot) {
                if (stripos($tache_libelle, $mot) !== false) return true;
            }
        } elseif ($categorie === 'À peindre') {
            foreach ($peintureMots as $mot) {
                if (stripos($tache_libelle, $mot) !== false) return true;
            }
        }
        return false;
    }

    /**
     * Récupère les tâches à afficher pour une pièce et une étape.
     */
    public static function getTachesParEtape($chantier_id, $piece_id, $etape_ordre) {
        $pdo = connectDB();
        $taches = $pdo->prepare("
            SELECT
                et.libelle AS etape,
                e.libelle AS element,
                tt.libelle AS tache,
                t.id AS tache_id,
                t.statut
            FROM Tache t
            JOIN EtapeTravail et ON t.ordre = et.ordre
            JOIN Element e ON t.element_id = e.id
            JOIN TacheType tt ON t.tache_type_id = tt.id
            WHERE t.chantier_id = :chantier_id
              AND t.piece_id = :piece_id
              AND t.ordre = :etape_ordre
            ORDER BY e.libelle
        ");
        $taches->bindParam(':chantier_id', $chantier_id, PDO::PARAM_INT);
        $taches->bindParam(':piece_id', $piece_id, PDO::PARAM_INT);
        $taches->bindParam(':etape_ordre', $etape_ordre, PDO::PARAM_INT);
        $taches->execute();
        return $taches->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Marque une étape comme terminée et passe à la suivante.
     */
    public static function marquerEtapeTerminee($chantier_id, $piece_id, $etape_ordre) {
        $pdo = connectDB();
        $pdo->prepare("
            UPDATE Tache
            SET statut = 'Terminé'
            WHERE chantier_id = :chantier_id
            AND piece_id = :piece_id
            AND ordre = :etape_ordre
            AND statut = 'À faire'
        ")->execute([
            ':chantier_id' => $chantier_id,
            ':piece_id' => $piece_id,
            ':etape_ordre' => $etape_ordre
        ]);
    }


    /**
     * Récupère l'étape actuelle (la première avec des tâches "À faire").
     */
    public static function getEtapeActuelle($chantier_id, $piece_id) {
        $pdo = connectDB();

        // 1. Chercher une étape avec des tâches "À faire"
        $etape = $pdo->prepare("
            SELECT et.id, et.libelle, et.ordre
            FROM EtapeTravail et
            JOIN Tache t ON et.ordre = t.ordre
            WHERE t.chantier_id = :chantier_id
            AND t.piece_id = :piece_id
            AND t.statut = 'À faire'
            GROUP BY et.ordre
            ORDER BY et.ordre
            LIMIT 1
        ");
        $etape->bindParam(':chantier_id', $chantier_id, PDO::PARAM_INT);
        $etape->bindParam(':piece_id', $piece_id, PDO::PARAM_INT);
        $etape->execute();
        $result = $etape->fetch(PDO::FETCH_ASSOC);

        // 2. Si aucune tâche "À faire", retourner la dernière étape avec des tâches terminées
        if (!$result) {
            $etape = $pdo->prepare("
                SELECT et.id, et.libelle, et.ordre
                FROM EtapeTravail et
                JOIN Tache t ON et.ordre = t.ordre
                WHERE t.chantier_id = :chantier_id
                AND t.piece_id = :piece_id
                GROUP BY et.ordre
                ORDER BY et.ordre DESC
                LIMIT 1
            ");
            $etape->bindParam(':chantier_id', $chantier_id, PDO::PARAM_INT);
            $etape->bindParam(':piece_id', $piece_id, PDO::PARAM_INT);
            $etape->execute();
            $result = $etape->fetch(PDO::FETCH_ASSOC);
        }

        // 3. Si aucune tâche n'existe, retourner la première étape par défaut
        if (!$result) {
            $result = $pdo->query("SELECT id, libelle, ordre FROM EtapeTravail ORDER BY ordre LIMIT 1")
                        ->fetch(PDO::FETCH_ASSOC);
        }

        return $result ?: ['id' => 0, 'libelle' => 'Aucune étape', 'ordre' => 0];
    }


    public static function getToutesLesTachesDeLEtape($chantier_id, $piece_id, $etape_ordre) {
        $pdo = connectDB();
        $taches = $pdo->prepare("
            SELECT
                et.libelle AS etape,
                e.libelle AS element,
                tt.libelle AS tache,
                t.id AS tache_id,
                t.statut
            FROM Tache t
            JOIN EtapeTravail et ON t.ordre = et.ordre
            JOIN Element e ON t.element_id = e.id
            JOIN TacheType tt ON t.tache_type_id = tt.id
            WHERE t.chantier_id = :chantier_id
            AND t.piece_id = :piece_id
            AND t.ordre = :etape_ordre
            ORDER BY t.statut, e.libelle  -- Les tâches terminées en bas
        ");
        $taches->bindParam(':chantier_id', $chantier_id, PDO::PARAM_INT);
        $taches->bindParam(':piece_id', $piece_id, PDO::PARAM_INT);
        $taches->bindParam(':etape_ordre', $etape_ordre, PDO::PARAM_INT);
        $taches->execute();
        return $taches->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function hasNextStep($chantier_id, $piece_id, $current_order) {
        $pdo = connectDB();
        $stmt = $pdo->prepare("
            SELECT 1
            FROM EtapeTravail et
            JOIN Tache t ON et.ordre = t.ordre
            WHERE t.chantier_id = :chantier_id
            AND t.piece_id = :piece_id
            AND et.ordre > :current_order
            LIMIT 1
        ");
        $stmt->bindParam(':chantier_id', $chantier_id, PDO::PARAM_INT);
        $stmt->bindParam(':piece_id', $piece_id, PDO::PARAM_INT);
        $stmt->bindParam(':current_order', $current_order, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchColumn() !== false;
    }


}
?>
