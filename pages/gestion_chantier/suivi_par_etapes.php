<?php
// Récupérer toutes les étapes avec leur avancement
$etapes = $pdo->query("
    SELECT et.id, et.libelle, et.ordre,
           COUNT(t.id) AS total_taches,
           SUM(CASE WHEN t.statut = 'Terminé' THEN 1 ELSE 0 END) AS taches_terminees
    FROM EtapeTravail et
    LEFT JOIN Tache t ON et.ordre = t.ordre AND t.chantier_id = $chantier_id
    GROUP BY et.id
    ORDER BY et.ordre
")->fetchAll();
?>

<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Suivi par étapes de travail</h5>
    </div>
    <div class="card-body">
        <?php if (empty($etapes)): ?>
            <div class="alert alert-info">Aucune étape définie.</div>
        <?php else: ?>
            <div class="accordion" id="etapesAccordion">
                <?php foreach ($etapes as $index => $etape): ?>
                    <?php
                    $pourcentage = $etape['total_taches'] > 0 ?
                        round(($etape['taches_terminees'] / $etape['total_taches']) * 100) : 0;
                    ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading<?= $etape['id'] ?>">
                            <button class="accordion-button <?= $index === 0 ? '' : 'collapsed' ?>"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapse<?= $etape['id'] ?>">
                                <?= htmlspecialchars($etape['libelle']) ?>
                                <span class="badge bg-<?= $pourcentage === 100 ? 'success' : 'primary' ?> ms-2">
                                    <?= $pourcentage ?>%
                                </span>
                            </button>
                        </h2>
                        <div id="collapse<?= $etape['id'] ?>"
                             class="accordion-collapse collapse <?= $index === 0 ? 'show' : '' ?>"
                             data-bs-parent="#etapesAccordion">
                            <div class="accordion-body">
                                <?php
                                // Récupérer les tâches de cette étape
                                $taches = $pdo->prepare("
                                    SELECT t.id, p.nom AS piece, e.libelle AS element, tt.libelle AS tache, t.statut
                                    FROM Tache t
                                    JOIN Piece p ON t.piece_id = p.id
                                    JOIN Element e ON t.element_id = e.id
                                    JOIN TacheType tt ON t.tache_type_id = tt.id
                                    WHERE t.chantier_id = :chantier_id AND t.ordre = :ordre
                                    ORDER BY p.nom, e.libelle
                                ");
                                $taches->bindParam(':chantier_id', $chantier_id, PDO::PARAM_INT);
                                $taches->bindValue(':ordre', $etape['ordre'], PDO::PARAM_INT);
                                $taches->execute();
                                $taches = $taches->fetchAll();
                                ?>

                                <?php if (empty($taches)): ?>
                                    <div class="alert alert-info">Aucune tâche pour cette étape.</div>
                                <?php else: ?>
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Pièce</th>
                                                    <th>Élément</th>
                                                    <th>Tâche</th>
                                                    <th>Statut</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($taches as $tache): ?>
                                                    <tr>
                                                        <td><?= htmlspecialchars($tache['piece']) ?></td>
                                                        <td><?= htmlspecialchars($tache['element']) ?></td>
                                                        <td><?= htmlspecialchars($tache['tache']) ?></td>
                                                        <td>
                                                            <span class="badge bg-<?= $tache['statut'] === 'Terminé' ? 'success' : 'warning' ?>">
                                                                <?= $tache['statut'] ?>
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <?php if ($tache['statut'] === 'À faire'): ?>
                                                                <a href="<?= BASE_URL ?>/?page=suivi_chantier&chantier_id=<?= $chantier_id ?>&mode=etapes&terminer=<?= $tache['id'] ?>"
                                                                   class="btn btn-sm btn-success">
                                                                    <i class="bi bi-check"></i> Terminer
                                                                </a>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
