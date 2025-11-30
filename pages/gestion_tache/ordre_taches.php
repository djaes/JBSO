<?php
// Récupérer l'ID de la série depuis l'URL
$serie_id = $_GET['serie_id'] ?? null;
if (!$serie_id) die("ID de série manquant.");

// Gestion des actions (suppression, ajout, etc.)
if (isset($_GET['delete'])) {
    $deleted = deleteTacheFromSerie($_GET['delete']);
    if ($deleted) {
        header("Location: " . BASE_URL . "/?page=ordre_taches&serie_id=$serie_id");
        exit;
    } else {
        echo "<div class='alert alert-danger'>Erreur lors de la suppression.</div>";
    }
}

// Récupérer les données pour la page
$taches = getTachesBySerie($serie_id);
$all_taches = getAllTachesTypes();
?>

<h1 class="mb-4">Ordre des Tâches <small class="text-muted">Série #<?= $serie_id ?></small></h1>

<!-- Liste des tâches -->
<div class="card mb-4">
    <ul id="tache-list" class="list-group list-group-flush">
        <?php foreach ($taches as $tache): ?>
            <li class="list-group-item" data-id="<?= $tache['id'] ?>" data-ordre="<?= $tache['ordre'] ?>" draggable="true">
                <i class="bi bi-grip-vertical me-2"></i>
                <?= htmlspecialchars($tache['tache']) ?>
                <span class="badge bg-secondary ms-2">Ordre: <?= $tache['ordre'] ?></span>
                <a href="<?= BASE_URL ?>/?page=ordre_taches&serie_id=<?= $serie_id ?>&delete=<?= $tache['id'] ?>" class="btn btn-sm btn-outline-danger float-end">
                    <i class="bi bi-trash"></i> Supprimer
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<!-- Formulaire pour ajouter une tâche -->
<div class="card mb-4">
    <div class="card-body">
        <form method="post" action="<?= BASE_URL ?>/?page=ordre_taches&serie_id=<?= $serie_id ?>" class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Tâche</label>
                <select name="tache_type_id" class="form-select" required>
                    <?php foreach ($all_taches as $tache): ?>
                        <option value="<?= $tache['id'] ?>"><?= htmlspecialchars($tache['libelle']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Ordre</label>
                <input type="number" name="ordre" class="form-control" required>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Ajouter</button>
            </div>
        </form>
    </div>
</div>

<a href="<?= BASE_URL ?>/?page=liste_series" class="btn btn-secondary">
    <i class="bi bi-arrow-left"></i> Retour à la liste
</a>
