<?php
session_start();
require 'config_bdd.php'; // Fichier avec la connexion PDO
require 'fonction/connectionRepository.php';

$repo = new ConnectionRepository($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usernameOrEmail = trim($_POST['nom_utilisateur']);
    $password = $_POST['mot_de_passe'];

    $user = $repo->findUserByUsernameOrEmail($usernameOrEmail);

    if ($user && password_verify($password, $user['mot_de_passe'])) {
        $_SESSION['utilisateur'] = [
            'id' => $user['id'],
            'nom_utilisateur' => $user['nom_utilisateur'],
            'role' => $user['role']
        ];
        $repo->updateLastAccess($user['id']);
        header('Location: /organisation/');
        exit();
    } else {
        $erreur = "Nom d'utilisateur ou mot de passe incorrect.";
        include 'connexion.php';
    }
}
?>
