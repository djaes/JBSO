<?php
$filter_element = $_GET['element'] ?? null;
$filter_degre = $_GET['degre'] ?? null;

$types_support = getAllTypesSupport($filter_element, $filter_degre);
$data = getElementsEtDegres();
?>

<h1 class="mb-4">Liste des Types de Support</h1>

<div class="card mb-4">
    <div class="card-body">
        <form method="get" action="<?= BASE_URL ?>/?page=liste_types_support" class="row g-3">
            <input type="hidden" name="page" value="liste_types_support">

            <div class="col-md-4">
                <label class="form-label">Élément</label>
                <select name="element" class="form-select">
                    <option value="">Tous les éléments</option>
                    <?php foreach ($data['elements'] as $element): ?>
                        <option value="<?= $element['id'] ?>" <?= $filter_element == $element['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($element['libelle']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label">Degré de finition</label>
                <select name="degre" class="form-select">
                    <option value="">Tous les degrés</option>
                    <?php foreach ($data['degres'] as $degre): ?>
                        <option value="<?= $degre['id'] ?>" <?= $filter_degre == $degre['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($degre['libelle']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Filtrer</button>
            </div>

            <div class="col-md-2 d-flex align-items-end">
                <a href="<?= BASE_URL ?>/?page=liste_types_support" class="btn btn-secondary w-100">Réinitialiser</a>
            </div>
        </form>
    </div>
</div>

<a href="<?= BASE_URL ?>/?page=ajout_qualite_support" class="btn btn-primary mb-3">
    <i class="bi bi-plus"></i> Ajouter une qualité de support
</a>

<?php if (is_array($types_support) && !empty($types_support)): ?>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Élément</th>
                    <th>Degré de finition</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($types_support as $type): ?>
                    <tr>
                        <td><?= $type['id'] ?></td>
                        <td><?= htmlspecialchars($type['element']) ?></td>
                        <td><?= htmlspecialchars($type['degre_finition']) ?></td>
                        <td>
                            <a href="<?= BASE_URL ?>/?page=ordre_taches&serie_id=<?= $type['id'] ?>" class="btn btn-sm btn-info">
                                <i class="bi bi-list-ol"></i> Définir l'ordre
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="alert alert-info">Aucun type de support trouvé.</div>
<?php endif; ?>
