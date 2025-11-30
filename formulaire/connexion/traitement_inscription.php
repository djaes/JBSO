<?php
require 'config_bdd.php';
require 'fonction/connectionRepository.php';

$repo = new ConnectionRepository($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['nom_utilisateur']);
    $email = trim($_POST['email']);
    $password = $_POST['mot_de_passe'];
    $confirmPassword = $_POST['confirm_mot_de_passe'];

    if ($password !== $confirmPassword) {
        $erreur = "Les mots de passe ne correspondent pas.";
        include 'inscription.php';
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    if ($repo->createUser($username, $email, $hashedPassword)) {
        header('Location: /connexion.php?inscription=success');
        exit();
    } else {
        $erreur = "Erreur lors de l'inscription.";
        include 'inscription.php';
    }
}
?>
