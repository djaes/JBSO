<?php
$chantierRepo = new ChantierRepository();
$degres = $chantierRepo->getDegresFinition();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];

    // Validation des champs (comme avant)
    // ...

    if (empty($errors)) {
        $data = [
            ':nom' => $nom,
            ':client' => $client,
            ':adresse' => $adresse,
            ':degre' => $degre,
            ':date_debut' => $date_debut,
            ':date_fin' => $date_fin ?: null
        ];

        if ($chantierRepo->addChantier($data)) {
            $_SESSION['success_message'] = "Chantier ajouté avec succès !";
            header("Location: " . BASE_URL . "/?page=liste_chantiers");
            exit;
        } else {
            $errors['database'] = "Erreur lors de l'enregistrement.";
        }
    }
}
?>

<h1 class="mb-4">
    <i class="bi bi-plus-circle-fill"></i> Ajouter un Nouveau Chantier
</h1>

<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="bi bi-building"></i> Informations du Chantier</h5>
    </div>
    <div class="card-body">
        <form method="post" class="row g-3 needs-validation" novalidate>
            <!-- Nom du chantier -->
            <div class="col-md-6">
                <label for="nom" class="form-label">Nom du chantier <span class="text-danger">*</span></label>
                <input type="text" class="form-control <?= isset($errors['nom']) ? 'is-invalid' : '' ?>"
                       id="nom" name="nom" value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>" required>
                <?php if (isset($errors['nom'])): ?>
                    <div class="invalid-feedback"><?= $errors['nom'] ?></div>
                <?php endif; ?>
            </div>

            <!-- Client -->
            <div class="col-md-6">
                <label for="client" class="form-label">Client <span class="text-danger">*</span></label>
                <input type="text" class="form-control <?= isset($errors['client']) ? 'is-invalid' : '' ?>"
                       id="client" name="client" value="<?= htmlspecialchars($_POST['client'] ?? '') ?>" required>
                <?php if (isset($errors['client'])): ?>
                    <div class="invalid-feedback"><?= $errors['client'] ?></div>
                <?php endif; ?>
            </div>

            <!-- Adresse -->
            <div class="col-md-12">
                <label for="adresse" class="form-label">Adresse <span class="text-danger">*</span></label>
                <textarea class="form-control <?= isset($errors['adresse']) ? 'is-invalid' : '' ?>"
                          id="adresse" name="adresse" rows="2" required><?= htmlspecialchars($_POST['adresse'] ?? '') ?></textarea>
                <?php if (isset($errors['adresse'])): ?>
                    <div class="invalid-feedback"><?= $errors['adresse'] ?></div>
                <?php endif; ?>
            </div>

            <!-- Degré de finition -->
            <div class="col-md-4">
                <label for="degre" class="form-label">Degré de finition <span class="text-danger">*</span></label>
                <select class="form-select <?= isset($errors['degre']) ? 'is-invalid' : '' ?>" id="degre" name="degre" required>
                    <option value="" selected disabled>Sélectionnez...</option>
                    <?php foreach ($degres_finition as $degre): ?>
                        <option value="<?= $degre ?>" <?= (isset($_POST['degre']) && $_POST['degre'] === $degre) ? 'selected' : '' ?>>
                            <?= $degre ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if (isset($errors['degre'])): ?>
                    <div class="invalid-feedback"><?= $errors['degre'] ?></div>
                <?php endif; ?>
            </div>

            <!-- Date de début -->
            <div class="col-md-4">
                <label for="date_debut" class="form-label">Date de début <span class="text-danger">*</span></label>
                <input type="date" class="form-control <?= isset($errors['date_debut']) ? 'is-invalid' : '' ?>"
                       id="date_debut" name="date_debut"
                       value="<?= htmlspecialchars($_POST['date_debut'] ?? date('Y-m-d')) ?>" required>
                <?php if (isset($errors['date_debut'])): ?>
                    <div class="invalid-feedback"><?= $errors['date_debut'] ?></div>
                <?php endif; ?>
            </div>

            <!-- Date de fin -->
            <div class="col-md-4">
                <label for="date_fin" class="form-label">Date de fin (optionnelle)</label>
                <input type="date" class="form-control <?= isset($errors['date_fin']) ? 'is-invalid' : '' ?>"
                       id="date_fin" name="date_fin"
                       value="<?= htmlspecialchars($_POST['date_fin'] ?? '') ?>">
                <?php if (isset($errors['date_fin'])): ?>
                    <div class="invalid-feedback"><?= $errors['date_fin'] ?></div>
                <?php endif; ?>
            </div>

            <!-- Boutons -->
            <div class="col-12 d-flex justify-content-end mt-4">
                <a href="<?= BASE_URL ?>/?page=liste_chantiers" class="btn btn-secondary me-2">
                    <i class="bi bi-arrow-left"></i> Annuler
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Enregistrer
                </button>
            </div>

            <?php if (isset($errors['database'])): ?>
                <div class="alert alert-danger mt-3">
                    <?= $errors['database'] ?>
                </div>
            <?php endif; ?>
        </form>
    </div>
</div>
