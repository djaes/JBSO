<?php
header("Content-type: text/css; charset: UTF-8");
session_start();
$userConfig = [];
if (isset($_SESSION['user'])) {
    $username = $_SESSION['user']['nom_utilisateur'];
    $userConfigPath = __DIR__ . "/../../config/users/config_$username.ini";
    echo __DIR__;
    if (file_exists($userConfigPath)) {
        $userConfig = parse_ini_file($userConfigPath, true);
    }
}
?>
:root {
    --primary-color: <?= $userConfig['theme']['primary_color'] ?? '#0d6efd' ?>;
    --secondary-color: <?= $userConfig['theme']['secondary_color'] ?? '#6c757d' ?>;
    --background-color: <?= $userConfig['theme']['background_color'] ?? '#f8f9fa' ?>;
    --text-color: <?= $userConfig['theme']['text_color'] ?? '#212529' ?>;
}

body {
    background-color: var(--background-color);
    color: var(--text-color);
}

.bg-primary {
    background-color: var(--primary-color) !important;
}
