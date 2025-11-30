<?php
// Inclure la fonction de connexion à la base de données
require_once __DIR__ . '/../connect_db.php';


function getTachesBySerie($serie_id) {
    $pdo = connectDB();
    $stmt = $pdo->prepare("SELECT std.id, tt.libelle AS tache, std.ordre FROM SerieTacheDetail std JOIN TacheType tt ON std.tache_type_id = tt.id WHERE std.serie_tache_id = :serie_id ORDER BY std.ordre");
    $stmt->bindParam(':serie_id', $serie_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllTachesTypes() {
    $pdo = connectDB();
    return $pdo->query("SELECT id, libelle FROM TacheType ORDER BY libelle")->fetchAll(PDO::FETCH_ASSOC);
}
?>
