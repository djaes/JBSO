<?php
    $chantierRepo = new ChantierRepository();

    // Récupérer les filtres
    $search = $_GET['search'] ?? '';
    $degre = $_GET['degre'] ?? '';
    $date_debut = $_GET['date_debut'] ?? '';
    $date_fin = $_GET['date_fin'] ?? '';

    // Récupérer les données via le repository
    $chantiers = $chantierRepo->getAllChantiers($search, $degre, $date_debut, $date_fin);
    $degres = $chantierRepo->getDegresFinition();
?>



<h1 class="mb-4">
    <i class="bi bi-hammer"></i> Liste des Chantiers
    <a href="<?= BASE_URL ?>/?page=ajout_chantier" class="btn btn-primary float-end">
        <i class="bi bi-plus"></i> Ajouter un chantier
    </a>
</h1>

<!-- Formulaire de recherche -->
<div class="card mb-4">
    <div class="card-header bg-light">
        <h5 class="mb-0"><i class="bi bi-search"></i> Rechercher un chantier</h5>
    </div>
    <div class="card-body">
        <form method="get" action="<?= BASE_URL ?>/?page=liste_chantiers" class="row g-3">
            <input type="hidden" name="page" value="liste_chantiers">

            <div class="col-md-4">
                <label class="form-label">Nom du chantier</label>
                <input type="text" name="search" class="form-control" value="<?= htmlspecialchars($search) ?>"
                       placeholder="Ex: Mr Pigache">
            </div>

            <div class="col-md-2">
                <label class="form-label">Degré de finition</label>
                <select name="degre" class="form-select">
                    <option value="">Tous</option>
                    <?php foreach ($degres as $d): ?>
                        <option value="<?= $d ?>" <?= $degre === $d ? 'selected' : '' ?>>
                            <?= htmlspecialchars($d) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label">Date début</label>
                <input type="date" name="date_debut" class="form-control" value="<?= $date_debut ?>">
            </div>

            <div class="col-md-2">
                <label class="form-label">Date fin</label>
                <input type="date" name="date_fin" class="form-control" value="<?= $date_fin ?>">
            </div>

            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-search"></i> Rechercher
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Résultats -->
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            Résultats (<?= count($chantiers) ?> chantier<?= count($chantiers) > 1 ? 's' : '' ?>)
        </h5>
        <?php if (!empty($search) || !empty($degre) || !empty($date_debut) || !empty($date_fin)): ?>
            <a href="<?= BASE_URL ?>/?page=liste_chantiers" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-x"></i> Réinitialiser
            </a>
        <?php endif; ?>
    </div>
    <div class="card-body">
        <?php if (empty($chantiers)): ?>
            <div class="alert alert-info">Aucun chantier trouvé.</div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Degré de finition</th>
                            <th>Date création</th>
                            <th>Pièces</th>
                            <th>Avancement</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($chantiers as $chantier): ?>
                            <?php
                            $pourcentage = $chantier['total_taches'] > 0 ?
                                round(($chantier['taches_terminees'] / $chantier['total_taches']) * 100) : 0;
                            ?>
                            <tr>
                                <td>
                                    <a href="<?= BASE_URL ?>/?page=suivi_chantier&chantier_id=<?= $chantier['id'] ?>">
                                        <?= htmlspecialchars($chantier['nom']) ?>
                                    </a>
                                </td>
                                <td>
                                    <span class="badge bg-<?= $chantier['degre_finition_global'] === 'Soignée' ? 'success' :
                                                        ($chantier['degre_finition_global'] === 'Standard' ? 'primary' : 'secondary') ?>">
                                        <?= htmlspecialchars($chantier['degre_finition_global']) ?>
                                    </span>
                                </td>
                                <td><?= (new DateTime($chantier['date_creation']))->format('d/m/Y') ?></td>
                                <td><?= $chantier['nb_pieces'] ?> pièce<?= $chantier['nb_pieces'] > 1 ? 's' : '' ?></td>
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
                                    <div class="btn-group" role="group">
                                        <a href="<?= BASE_URL ?>/?page=suivi_chantier&chantier_id=<?= $chantier['id'] ?>"
                                           class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i> Voir
                                        </a>
                                        <a href="<?= BASE_URL ?>/?page=modifier_chantier&chantier_id=<?= $chantier['id'] ?>"
                                           class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i> Modifier
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
