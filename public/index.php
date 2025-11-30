<?php
session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);

// 1. Charge la configuration et les routes
require_once __DIR__ . '/../config/config.php';

// 2. Récupère la page demandée
$page = $_GET['page'] ?? 'accueil';
if (!array_key_exists($page, $routes)) {
    header("HTTP/1.0 404 Not Found");
    die("Page introuvable");
}

// 3. Redirige vers la connexion si la page est protégée et que l'utilisateur n'est pas connecté
if (isset($routes[$page]['protected']) && $routes[$page]['protected'] && !isset($_SESSION['user'])) {
    header('Location: index.php?page=connexion');
    exit();
}

// Vérification du rôle
    if (isset($routes[$page]['roles']) && !in_array($_SESSION['user']['role'], $routes[$page]['roles'])) {
        header('Location: index.php?page=accueil&error=' . urlencode("Accès non autorisé."));
        exit();
    }

// 4. Charge les dépendances de la page
if (isset($routes[$page]['dependencies'])) {
    foreach ($routes[$page]['dependencies'] as $dependency) {
        if (file_exists($dependency)) {
            require_once $dependency;
        } else {
            die("Fichier introuvable : $dependency");
        }
    }
}

// 5. Connexion à la base de données
$pdo = connectDB();
if (!$pdo) {
    die("Impossible de se connecter à la base de données.");
}

// 6.Instancie le repository pour les pages concernées
if (in_array($page, ['connexion', 'inscription', 'mot_de_passe_oublie', 'reinitialiser_mot_de_passe'])) {
    if (!file_exists(FONCTIONS_CONNEXION_PATH . '/ConnexionRepository.php')) {
        die("Erreur : Le fichier ConnexionRepository.php est introuvable.");
    }
    require_once FONCTIONS_CONNEXION_PATH . '/ConnexionRepository.php';
    $connectionRepo = new ConnectionRepository($pdo);
}


// 7. Variables pour les messages d'erreur/succès
$error = null;
$success = null;

// 8. Gestion des actions spécifiques à la page
switch ($page) {
    case 'connexion':
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['connexion'])) {
            $usernameOrEmail = trim($_POST['username_or_email']);
            $password = $_POST['password'];

            if (empty($usernameOrEmail) || empty($password)) {
                $error = "Tous les champs sont obligatoires.";
            } else {
                $user = $connectionRepo->findUserByUsernameOrEmail($usernameOrEmail);
                // Affiche le contenu de $user pour débogage
                    echo '<pre>';
                    print_r($user);
                    print_r($_SESSION);
                    echo '</pre>';
                    exit(); // Arrête l'exécution pour voir le résultat
                        
                if ($user && password_verify($password, $user['mot_de_passe'])) {
                    $_SESSION['user'] = $user;
                    $connectionRepo->updateLastAccess($user['id']);
                    header('Location: index.php?page=organisation');
                    exit();
                } else {
                    $error = "Identifiants incorrects.";
                }
            }
        }
        break;

    case 'inscription':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = $_POST['password'];
            $passwordConfirm = $_POST['password_confirm'];

            // Validation des champs
            if (empty($username) || empty($email) || empty($password) || empty($passwordConfirm)) {
                $error = "Tous les champs sont obligatoires.";
            } elseif ($password !== $passwordConfirm) {
                $error = "Les mots de passe ne correspondent pas.";
            } elseif ($connectionRepo->findUserByUsernameOrEmail($username)) {
                $error = "Ce nom d'utilisateur est déjà pris.";
            } elseif ($connectionRepo->findUserByUsernameOrEmail($email)) {
                $error = "Cet email est déjà utilisé.";
            } else {
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                if ($connectionRepo->createUser($username, $email, $hashedPassword)) {
                    $success = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
                    header('Location: index.php?page=connexion&success=' . urlencode($success));
                    exit();
                } else {
                    $error = "Erreur lors de l'inscription. Veuillez réessayer.";
                }
            }
        }
        break;

    case 'mot_de_passe_oublie':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            if (empty($email)) {
                $error = "L'email est obligatoire.";
            } else {
                $user = $connectionRepo->findUserByUsernameOrEmail($email);
                if ($user) {
                    $token = bin2hex(random_bytes(32));
                    $expiration = date('Y-m-d H:i:s', strtotime('+1 hour'));
                    if ($connectionRepo->updateResetToken($email, $token, $expiration)) {
                        // TODO: Envoyer un email avec le lien de réinitialisation
                        $success = "Un lien de réinitialisation vous a été envoyé par email.";
                    } else {
                        $error = "Erreur lors de la génération du lien de réinitialisation.";
                    }
                } else {
                    $error = "Aucun compte associé à cet email.";
                }
            }
        }
        break;

    case 'reinitialiser_mot_de_passe':
        if (!isset($_GET['token'])) {
            header('Location: index.php?page=mot_de_passe_oublie');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_GET['token'];
            $newPassword = $_POST['new_password'];
            $newPasswordConfirm = $_POST['new_password_confirm'];

            if (empty($newPassword) || empty($newPasswordConfirm)) {
                $error = "Tous les champs sont obligatoires.";
            } elseif ($newPassword !== $newPasswordConfirm) {
                $error = "Les mots de passe ne correspondent pas.";
            } else {
                $user = $connectionRepo->findUserByResetToken($token);
                if ($user) {
                    $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
                    if ($connectionRepo->updatePassword($user['id'], $hashedPassword)) {
                        $success = "Mot de passe mis à jour. Vous pouvez maintenant vous connecter.";
                        header('Location: index.php?page=connexion&success=' . urlencode($success));
                        exit();
                    } else {
                        $error = "Erreur lors de la mise à jour du mot de passe.";
                    }
                } else {
                    $error = "Token invalide ou expiré.";
                }
            }
        }
        break;

    case 'deconnexion':
        session_unset();
        session_destroy();
        header('Location: index.php?page=connexion');
        exit();
        break;

    case 'organisation':
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?page=connexion');
            exit();
        }
        break;
}

// 9. Gestion du chantier_id (si utilisé dans ton appli)
if (isset($_GET['chantier_id'])) {
    $_SESSION['chantier_id'] = $_GET['chantier_id'];
}
$chantier_id = $_SESSION['chantier_id'] ?? null;


// 10. Affiche la page
$title = $routes[$page]['title'];
$custom_js = $routes[$page]['js'];
require_once INCLUDE_PATH . '/head.php';
require_once  $routes[$page]['file'];
require_once INCLUDE_PATH . '/footer.php';
?>
