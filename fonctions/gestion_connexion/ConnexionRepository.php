<?php
// fonction/connectionRepository.php
require_once __DIR__ . '/../connect_db.php';

class ConnectionRepository
{
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
}
?>
