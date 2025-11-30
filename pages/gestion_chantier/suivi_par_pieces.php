<?php
// Récupérer toutes les pièces du chantier
$pieces = $pdo->prepare("
    SELECT p.id, p.nom, tp.libelle AS type_piece, p.etage, p.degre_finition,
           (SELECT COUNT(*) FROM Tache t WHERE t.piece_id = p.id AND t.statut = 'À faire') AS taches_restantes
    FROM Piece p
    JOIN TypePiece tp ON p.type_piece_id = tp.id
    WHERE p.chantier_id = :chantier_id
    ORDER BY p.etage, tp.libelle, p.nom
");
$pieces->bindParam(':chantier_id', $chantier_id, PDO::PARAM_INT);
$pieces->execute();
$pieces = $pieces->fetchAll();
?>

<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Suivi par pièces</h5>
        <a href="<?= BASE_URL ?>/?page=suivi_chantier&chantier_id=<?= $chantier_id ?>&mode=pieces&regenerer=1"
           class="btn btn-sm btn-warning">
            <i class="bi bi-arrow-clockwise"></i> Régénérer toutes les tâches
        </a>
    </div>
    <div class="card-body">
        <?php if (empty($pieces)): ?>
            <div class="alert alert-info">Aucune pièce trouvée pour ce chantier.</div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Pièce</th>
                            <th>Type</th>
                            <th>Étage</th>
                            <th>Degré</th>
                            <th>Tâches restantes</th>
                            <th>Avancement</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pieces as $piece): ?>
                            <?php
                            // Calculer l'avancement
                            $total_taches = $pdo->prepare("
                                SELECT COUNT(*) FROM Tache WHERE piece_id = :piece_id
                            ");
                            $total_taches->bindParam(':piece_id', $piece['id'], PDO::PARAM_INT);
                            $total_taches->execute();
                            $total = $total_taches->fetchColumn();

                            $terminées = $total - $piece['taches_restantes'];
                            $pourcentage = $total > 0 ? round(($terminées / $total) * 100) : 0;
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($piece['nom']) ?></td>
                                <td><?= htmlspecialchars($piece['type_piece']) ?></td>
                                <td><?= htmlspecialchars($piece['etage']) ?></td>
                                <td><?= htmlspecialchars($piece['degre_finition']) ?></td>
                                <td>
                                    <span class="badge bg-<?= $piece['taches_restantes'] > 0 ? 'warning' : 'success' ?>">
                                        <?= $piece['taches_restantes'] ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar <?= $pourcentage === 100 ? 'bg-success' : 'bg-primary' ?>"
                                             role="progressbar"
                                             style="width: <?= $pourcentage ?>%"
                                             aria-valuenow="<?= $pourcentage ?>"
                                             aria-valuemin="0"
                                             aria-valuemax="100">
                                            <?= $pourcentage ?>%
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="<?= BASE_URL ?>/?page=detail_piece&chantier_id=<?= $chantier_id ?>&piece_id=<?= $piece['id'] ?>"
                                       class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i> Voir
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
