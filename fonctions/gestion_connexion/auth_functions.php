<?php
// fonctions/auth_functions.php
require_once __DIR__ . '/ConnectionRepository.php';

function handleLogin(PDO $pdo, string $usernameOrEmail, string $password): array
{
    $repo = new ConnectionRepository($pdo);
    $user = $repo->findUserByUsernameOrEmail($usernameOrEmail);

    if (!$user || !password_verify($password, $user['mot_de_passe'])) {
        return ['success' => false, 'message' => 'Identifiants incorrects.'];
    }

    $repo->updateLastAccess($user['id']);
    return ['success' => true, 'user' => $user];
}

function handleRegister(PDO $pdo, string $username, string $email, string $password): array
{
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $repo = new ConnectionRepository($pdo);

    if (!$repo->createUser($username, $email, $hashedPassword)) {
        return ['success' => false, 'message' => 'Erreur lors de l\'inscription.'];
    }

    return ['success' => true];
}

function handleForgotPassword(PDO $pdo, string $email): array
{
    $repo = new ConnectionRepository($pdo);
    $user = $repo->findUserByUsernameOrEmail($email);

    if (!$user) {
        return ['success' => false, 'message' => 'Aucun compte associé à cet email.'];
    }

    $token = bin2hex(random_bytes(32));
    $expiration = date('Y-m-d H:i:s', strtotime('+1 hour'));
    $repo->updateResetToken($email, $token, $expiration);

    // TODO: Envoyer un email avec le lien de réinitialisation (ex: index.php?page=reset_password&token=$token)
    return ['success' => true, 'message' => 'Lien de réinitialisation envoyé.'];
}

function handleResetPassword(PDO $pdo, string $token, string $newPassword): array
{
    $repo = new ConnectionRepository($pdo);
    $user = $repo->findUserByResetToken($token);

    if (!$user) {
        return ['success' => false, 'message' => 'Token invalide ou expiré.'];
    }

    $newHashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
    $repo->updatePassword($user['id'], $newHashedPassword);
    return ['success' => true, 'message' => 'Mot de passe mis à jour.'];
}
?>
