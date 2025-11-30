<?php
require 'config_bdd.php';
require 'fonction/connectionRepository.php';

$repo = new ConnectionRepository($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $user = $repo->findUserByUsernameOrEmail($email);

    if ($user) {
        $token = bin2hex(random_bytes(32));
        $expiration = date('Y-m-d H:i:s', strtotime('+1 hour'));

        if ($repo->updateResetToken($email, $token, $expiration)) {
            $lien = "https://ton-domaine.fr/reinitialiser-mot-de-passe.php?token=$token";
            mail($email, "Réinitialisation de votre mot de passe", "Cliquez ici : $lien");
            $message = "Lien de réinitialisation envoyé !";
        } else {
            $erreur = "Erreur lors de la génération du lien.";
        }
    } else {
        $erreur = "Aucun compte trouvé avec cet email.";
    }
    include 'mot-de-passe-oublie.php';
}
?>
