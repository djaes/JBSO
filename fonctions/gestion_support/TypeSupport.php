<?php
// Inclure la fonction de connexion à la base de données
require_once __DIR__ . '/../connect_db.php';


function getAllTypesSupport($element_id = null, $degre_finition_id = null) {
    $pdo = connectDB();
    $sql = "SELECT st.id, e.libelle AS element, df.libelle AS degre_finition FROM SerieTache st JOIN Element e ON st.element_id = e.id JOIN DegreFinition df ON st.degre_finition_id = df.id";
    $conditions = [];
    if ($element_id) $conditions[] = "e.id = :element_id";
    if ($degre_finition_id) $conditions[] = "df.id = :degre_finition_id";
    if (!empty($conditions)) $sql .= " WHERE " . implode(" AND ", $conditions);
    $sql .= " ORDER BY df.id, e.libelle";
    $stmt = $pdo->prepare($sql);
    if ($element_id) $stmt->bindParam(':element_id', $element_id, PDO::PARAM_INT);
    if ($degre_finition_id) $stmt->bindParam(':degre_finition_id', $degre_finition_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getElementsEtDegres() {
    $pdo = connectDB();
    $elements = $pdo->query("SELECT id, libelle FROM Element ORDER BY libelle")->fetchAll();
    $degres = $pdo->query("SELECT id, libelle FROM DegreFinition ORDER BY id")->fetchAll();
    return ['elements' => $elements, 'degres' => $degres];
}
?>
