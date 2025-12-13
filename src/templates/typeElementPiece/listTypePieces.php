<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Types de Pièces</title>
</head>
<body>
    <h1>Liste des Types de Pièces</h1>
    <ul>
        <?php foreach ($typePieces as $typePiece): ?>
            <li>
                <a href="/type-element-piece/manage/<?= $typePiece['id'] ?>">
                    <?= htmlspecialchars($typePiece['label']) ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
