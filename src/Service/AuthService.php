<?php
namespace App\Service;

// fonctions/auth_functions.php
require_once __DIR__ . '/ConnectionRepository.php';
class AuthService {

    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Récupère un utilisateur par son nom d'utilisateur ou email.
     */
    public function findUserByUsernameOrEmail(string $usernameOrEmail): ?array
    {
        $stmt = $this->pdo->prepare("
            SELECT * FROM utilisateurs
            WHERE nom_utilisateur = :usernameOrEmail OR email = :usernameOrEmail
        ");
        $stmt->execute(['usernameOrEmail' => $usernameOrEmail]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Crée un nouvel utilisateur.
     */
    public function createUser(string $username, string $email, string $hashedPassword): bool
    {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO utilisateurs (nom_utilisateur, email, mot_de_passe)
                VALUES (:username, :email, :password)
            ");
            return $stmt->execute([
                'username' => $username,
                'email' => $email,
                'password' => $hashedPassword
            ]);
        } catch (PDOException $e) {
            error_log("Erreur lors de la création de l'utilisateur : " . $e->getMessage());
            return false;
        }
    }

    /**
     * Met à jour le token de réinitialisation de mot de passe.
     */
    public function updateResetToken(string $email, string $token, string $expiration): bool
    {
        $stmt = $this->pdo->prepare("
            UPDATE utilisateurs
            SET reset_token = :token, reset_token_expiration = :expiration
            WHERE email = :email
        ");
        return $stmt->execute([
            'token' => $token,
            'expiration' => $expiration,
            'email' => $email
        ]);
    }

    /**
     * Récupère un utilisateur par son token de réinitialisation.
     */
    public function findUserByResetToken(string $token): ?array
    {
        $stmt = $this->pdo->prepare("
            SELECT * FROM utilisateurs
            WHERE reset_token = :token AND reset_token_expiration > NOW()
        ");
        $stmt->execute(['token' => $token]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Met à jour le mot de passe d'un utilisateur.
     */
    public function updatePassword(int $userId, string $newHashedPassword): bool
    {
        $stmt = $this->pdo->prepare("
            UPDATE utilisateurs
            SET mot_de_passe = :password, reset_token = NULL, reset_token_expiration = NULL
            WHERE id = :id
        ");
        return $stmt->execute([
            'password' => $newHashedPassword,
            'id' => $userId
        ]);
    }

    /**
     * Met à jour la date du dernier accès.
     */
    public function updateLastAccess(int $userId): bool
    {
        $stmt = $this->pdo->prepare("
            UPDATE utilisateurs
            SET dernier_acces = NOW()
            WHERE id = :id
        ");
        return $stmt->execute(['id' => $userId]);
    }

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



}
?>
