<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? htmlspecialchars($title) : 'JBSOrganizer' ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Ton CSS personnalisé -->
     
    <!--<link rel="stylesheet" href="<?= CSS_URL ?>/style.css">-->
    <link rel="stylesheet" href="/JBSO/assets/css/style.css">    
</head>
    <body>
        <!-- Barre de navigation commune -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="header-logo">
                <img src="/JBSO/assets/image/logo_jbso.jpg" alt="Logo JBSOrganizer" style="height: 50px; margin-right: 10px;">
                <a class="nav-link" href="<?= BASE_URL ?>/?page=accueil">
                        <span style="font-size: 24px; font-weight: bold; vertical-align: middle; color: #333;">JBSOrganizer</span>
                </a>
            </div>
            <div class="container">
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav navbar-collapse">                            
                        <?php if (isset($_SESSION['user'])): ?>                        
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="chantiersDropdown" role="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-hammer"></i> Chantiers
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="<?= BASE_URL ?>/?page=liste_chantiers">
                                            <i class="bi bi-list"></i> Liste des chantiers
                                        </a>
                                    </li>
                                </ul>    
                            </li>        
                            <li class="nav-item nav-right">
                                <a class="nav-link" href="index.php?page=deconnexion">Déconnexion</a>
                            </li>     
                        <?php else: ?>
                            <li class="nav-item nav-right">
                                <a class="nav-link" href="index.php?page=connexion">Connexion</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Conteneur principal avec menu latéral -->
        
        <?php if (isset($_SESSION['user'])): ?>
        <div class="container mt-4">
            <div class="row">
                <!-- Menu latéral -->
                <div class="col-md-3">
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="bi bi-menu-button-wide"></i> Menu</h5>
                        </div>
                        <div class="card-body">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="<?= BASE_URL ?>/?page=accueil">
                                        <i class="bi bi-house"></i> Accueil
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="<?= BASE_URL ?>/?page=liste_chantiers">
                                        <i class="bi bi-list-task"></i> Chantiers
                                    </a>
                                </li>
                                <?php if (isset($_GET['chantier_id'])): ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?= BASE_URL ?>/?page=suivi_chantier&chantier_id=<?= $_GET['chantier_id'] ?>">
                                            <i class="bi bi-eye"></i> Suivi du chantier
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <? //php else: ?>
            <?php endif; ?>
                <!-- Contenu principal -->
                <div class=" ma-div">
