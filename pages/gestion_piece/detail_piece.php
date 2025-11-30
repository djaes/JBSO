<?php
$pdo = connectDB();

$chantier_id = $_GET['chantier_id'] ?? null;
$piece_id = $_GET['piece_id'] ?? null;

if (!$chantier_id || !$piece_id) die("Paramètres manquants");

// Récupérer les informations de la pièce
$piece = $pdo->prepare("
    SELECT p.nom, tp.libelle AS type_piece, p.etage, p.degre_finition
    FROM Piece p
    JOIN TypePiece tp ON p.type_piece_id = tp.id
    WHERE p.id = :piece_id
");
$piece->bindParam(':piece_id', $piece_id, PDO::PARAM_INT);
$piece->execute();
$piece = $piece->fetch(PDO::FETCH_ASSOC);

// Gestion des actions
if (isset($_GET['terminer'])) {
    $pdo->prepare("UPDATE Tache SET statut = 'Terminé' WHERE id = :tache_id")
        ->execute([':tache_id' => $_GET['terminer']]);
    header("Location: " . BASE_URL . "/?page=detail_piece&chantier_id=$chantier_id&piece_id=$piece_id");
    exit;
}

if (isset($_GET['regenerer'])) {
    TacheGenerator::genererTachesPourPiece($chantier_id, $piece_id);
    header("Location: " . BASE_URL . "/?page=detail_piece&chantier_id=$chantier_id&piece_id=$piece_id");
    exit;
}

// Récupérer les étapes avec leurs tâches
$etapes = $pdo->query("SELECT id, libelle, ordre FROM EtapeTravail ORDER BY ordre")->fetchAll();
?>

<h2 class="mb-4">
    <?= htmlspecialchars($piece['nom']) ?>
    <small class="text-muted">
        (<?= htmlspecialchars($piece['type_piece']) ?>, <?= $piece['etage'] ?>,
        Degré: <?= htmlspecialchars($piece['degre_finition']) ?>)
    </small>
</h2>

<div class="d-flex justify-content-between mb-3">
    <a href="<?= BASE_URL ?>/?page=suivi_chantier&chantier_id=<?= $chantier_id ?>&mode=pieces"
       class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Retour
    </a>
    <a href="<?= BASE_URL ?>/?page=detail_piece&chantier_id=<?= $chantier_id ?>&piece_id=<?= $piece_id ?>&regenerer=1"
       class="btn btn-warning">
        <i class="bi bi-arrow-clockwise"></i> Régénérer les tâches
    </a>
</div>

<div class="card mb-4">
    <div class="card-body">
        <div class="accordion" id="pieceAccordion">
            <?php foreach ($etapes as $index => $etape): ?>
                <?php
                // Récupérer les tâches de cette étape pour cette pièce
                $taches = $pdo->prepare("
                    SELECT t.id, e.libelle AS element, tt.libelle AS tache, t.statut
                    FROM Tache t
                    JOIN Element e ON t.element_id = e.id
                    JOIN TacheType tt ON t.tache_type_id = tt.id
                    WHERE t.chantier_id = :chantier_id
                      AND t.piece_id = :piece_id
                      AND t.ordre = :ordre
                    ORDER BY e.libelle
                ");
                $taches->bindParam(':chantier_id', $chantier_id, PDO::PARAM_INT);
                $taches->bindParam(':piece_id', $piece_id, PDO::PARAM_INT);
                $taches->bindValue(':ordre', $etape['ordre'], PDO::PARAM_INT);
                $taches->execute();
                $taches = $taches->fetchAll();

                $taches_terminees = array_filter($taches, fn($t) => $t['statut'] === 'Terminé');
                $pourcentage = count($taches) > 0 ? round((count($taches_terminees) / count($taches)) * 100) : 0;
                ?>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingEtape<?= $etape['id'] ?>">
                        <button class="accordion-button <?= $index === 0 ? '' : 'collapsed' ?>"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#collapseEtape<?= $etape['id'] ?>">
                            <?= htmlspecialchars($etape['libelle']) ?>
                            <span class="badge bg-<?= $pourcentage === 100 ? 'success' : 'primary' ?> ms-2">
                                <?= $pourcentage ?>%
                            </span>
                        </button>
                    </h2>
                    <div id="collapseEtape<?= $etape['id'] ?>"
                         class="accordion-collapse collapse <?= $index === 0 ? 'show' : '' ?>"
                         data-bs-parent="#pieceAccordion">
                        <div class="accordion-body">
                            <?php if (empty($taches)): ?>
                                <div class="alert alert-info">Aucune tâche pour cette étape.</div>
                            <?php else: ?>
                                <div class="list-group">
                                    <?php foreach ($taches as $tache): ?>
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <span class="badge bg-primary me-2"><?= htmlspecialchars($tache['element']) ?></span>
                                                <?= htmlspecialchars($tache['tache']) ?>
                                                <?php if ($tache['statut'] === 'Terminé'): ?>
                                                    <span class="text-success ms-2">
                                                        <i class="bi bi-check-circle-fill"></i> Terminé
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <?php if ($tache['statut'] === 'À faire'): ?>
                                                <a href="<?= BASE_URL ?>/?page=detail_piece&chantier_id=<?= $chantier_id ?>&piece_id=<?= $piece_id ?>&terminer=<?= $tache['id'] ?>"
                                                   class="btn btn-sm btn-success">
                                                    <i class="bi bi-check"></i> Terminer
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
