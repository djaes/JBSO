<?php
// Inclure la fonction de connexion à la base de données
require_once __DIR__ . '/../connect_db.php';


function addQualiteSupport($element_id, $degre_finition_id) {
    $pdo = connectDB();
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM SerieTache WHERE element_id = :element_id AND degre_finition_id = :degre_finition_id");
    $stmt->bindParam(':element_id', $element_id, PDO::PARAM_INT);
    $stmt->bindParam(':degre_finition_id', $degre_finition_id, PDO::PARAM_INT);
    $stmt->execute();
    if ($stmt->fetchColumn() > 0) return 'duplicate';
    $stmt = $pdo->prepare("INSERT INTO SerieTache (element_id, degre_finition_id) VALUES (:element_id, :degre_finition_id)");
    $stmt->bindParam(':element_id', $element_id, PDO::PARAM_INT);
    $stmt->bindParam(':degre_finition_id', $degre_finition_id, PDO::PARAM_INT);
    return $stmt->execute() ? 'success' : false;
}
?>
