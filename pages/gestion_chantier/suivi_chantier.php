<?php
$pieceRepo = new PieceRepository();
$chantierRepo = new ChantierRepository();

$chantier_id = $_GET['chantier_id'] ?? null;
if (!$chantier_id) die("ID de chantier manquant");

// Récupérer les pièces du chantier
$pieces = $pieceRepo->getPiecesByChantier($chantier_id);



?>
<h2 class="mb-4">Pièces du Chantier</h2>

<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Liste des pièces</h5>
        <a href="<?= BASE_URL ?>/?page=ajout_piece&chantier_id=<?= $chantier_id ?>"
           class="btn btn-sm btn-primary">
            <i class="bi bi-plus"></i> Ajouter une pièce
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
                            <th>Nom</th>
                            <th>Type</th>
                            <th>Étage</th>
                            <th>Degré</th>
                            <th>Avancement</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pieces as $piece): ?>
                            <?php $avancement = $pieceRepo->getAvancementPiece($piece['id']); ?>
                            <tr>
                                <td>
                                     
                                    <a href="<?= BASE_URL ?>/?page=detail_piece&piece_id=<?= $piece['id'] ?>&chantier_id=<?= $chantier_id ?>">
                                        <?= htmlspecialchars($piece['nom']) ?>
                                    </a>
                                </td>
                                <td><?= htmlspecialchars($piece['type_piece']) ?></td>
                                <td><?= htmlspecialchars($piece['etage']) ?></td>
                                <td>
                                    <span class="badge bg-<?=
                                        $piece['degre_finition'] === 'Soignée' ? 'success' :
                                        ($piece['degre_finition'] === 'Standard' ? 'primary' : 'secondary')
                                    ?>">
                                        <?= htmlspecialchars($piece['degre_finition']) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar <?= $avancement['pourcentage'] === 100 ? 'bg-success' : 'bg-primary' ?>"
                                             style="width: <?= $avancement['pourcentage'] ?>%">
                                            <?= $avancement['pourcentage'] ?>%
                                        </div>
                                    </div>
                                    <small class="text-muted">
                                        <?= $avancement['terminees'] ?>/<?= $avancement['total'] ?> tâches
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="<?= BASE_URL ?>/?page=detail_piece&piece_id=<?= $piece['id'] ?>&chantier_id=<?= $chantier_id ?>"
                                           class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= BASE_URL ?>/?page=modifier_piece&piece_id=<?= $piece['id'] ?>&chantier_id=<?= $chantier_id ?>"
                                           class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="<?= BASE_URL ?>/?page=supprimer_piece&piece_id=<?= $piece['id'] ?>&chantier_id=<?= $chantier_id ?>"
                                           class="btn btn-sm btn-danger"
                                           onclick="return confirm('Voulez-vous vraiment supprimer cette pièce ?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<a href="<?= BASE_URL ?>/?page=liste_chantiers" class="btn btn-secondary mt-3">
    <i class="bi bi-arrow-left"></i> Retour à la liste des chantiers
</a>
