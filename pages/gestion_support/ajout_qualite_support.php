<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $element_id = $_POST['element_id'] ?? null;
    $degre_finition_id = $_POST['degre_finition_id'] ?? null;

    if ($element_id && $degre_finition_id) {
        $result = addQualiteSupport($element_id, $degre_finition_id);

        if ($result === 'success') {
            echo "<div class='alert alert-success'>Qualité de support ajoutée avec succès !</div>";
        } elseif ($result === 'duplicate') {
            echo "<div class='alert alert-warning'>Cette qualité de support existe déjà.</div>";
        } else {
            echo "<div class='alert alert-danger'>Erreur lors de l'ajout.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Veuillez sélectionner un élément et un degré de finition.</div>";
    }
}

$data = getElementsEtDegres();
?>

<h1 class="mb-4">Ajouter une Qualité de Support</h1>

<div class="card mb-4">
    <div class="card-body">
        <form method="post" class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Élément</label>
                <select name="element_id" class="form-select" required>
                    <option value="" selected disabled>Sélectionnez un élément</option>
                    <?php foreach ($data['elements'] as $element): ?>
                        <option value="<?= $element['id'] ?>"><?= htmlspecialchars($element['libelle']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Degré de finition</label>
                <select name="degre_finition_id" class="form-select" required>
                    <option value="" selected disabled>Sélectionnez un degré de finition</option>
                    <?php foreach ($data['degres'] as $degre): ?>
                        <option value="<?= $degre['id'] ?>"><?= htmlspecialchars($degre['libelle']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-plus"></i> Ajouter
                </button>
                <a href="<?= BASE_URL ?>/?page=liste_types_support" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Annuler
                </a>
            </div>
        </form>
    </div>
</div>
