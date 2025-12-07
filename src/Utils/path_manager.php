<?php
class PathManager {
    private static $paths = [];
    private static $initialized = false;

    /**
     * Initialise les chemins de base.
     */
    public static function init() {
        if (self::$initialized) {
            return;
        }

        // Détermine automatiquement le chemin racine si non fourni
        $rootPath = dirname(__DIR__, 1) . DIRECTORY_SEPARATOR;

        self::$paths = [
            'root'      => $rootPath,
            'asset'    => $rootPath . 'asset' . DIRECTORY_SEPARATOR,
            'css'       => $rootPath . 'asset' . DIRECTORY_SEPARATOR . 'css' . DIRECTORY_SEPARATOR,
            'js'        => $rootPath . 'asset' . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR,
            'images'    => $rootPath . 'asset' . DIRECTORY_SEPARATOR . 'image' . DIRECTORY_SEPARATOR,
            'config'    => $rootPath . 'config' . DIRECTORY_SEPARATOR,
            'fonction' => $rootPath . 'fonction' . DIRECTORY_SEPARATOR,
            'include'  => $rootPath . 'include' . DIRECTORY_SEPARATOR,
            'page'     => $rootPath . 'page' . DIRECTORY_SEPARATOR,
            'formulaire'=> $rootPath . 'formulaire' . DIRECTORY_SEPARATOR,
            'public'    => $rootPath . 'public' . DIRECTORY_SEPARATOR,
            'base_url'  => 'http://192.168.0.100/',
        ];

        self::$initialized = true;
    }

    /**
     * Récupère un chemin absolu.
     *
     * @param string $key     Clé du chemin (ex: 'pages', 'css').
     * @param string $subpath Sous-chemin optionnel.
     * @return string
     */
    public static function getAbsolutePath($key, $subpath = '') {
        if (!isset(self::$paths[$key])) {
            throw new Exception("Chemin '$key' non défini.");
        }
        return self::$paths[$key] . ltrim($subpath, DIRECTORY_SEPARATOR);
    }

    /**
     * Récupère une URL complète.
     *
     * @param string $key     Clé du chemin (ex: 'assets', 'pages').
     * @param string $subpath Sous-chemin optionnel.
     * @return string
     */
    public static function getUrl($key, $subpath = '') {
        if (!isset(self::$paths[$key])) {
            throw new Exception("Chemin '$key' non défini.");
        }
        // Utilise 'assets' pour construire l'URL, car c'est la clé du dossier parent
        if (in_array($key, ['css', 'js', 'image'])) {
            return self::$paths['base_url'] . 'asset/' . $key . '/' . ltrim($subpath, '/');
        } else {
            return self::$paths['base_url'] . $key . '/' . ltrim($subpath, '/');
        }
    }

    /**
     * Vérifie si un fichier existe à un chemin donné.
     *
     * @param string $key     Clé du chemin.
     * @param string $subpath Sous-chemin vers le fichier.
     * @return bool
     */
    
    public static function fileExists($key, $subpath = '') {
        $fullPath = self::getAbsolutePath($key, $subpath);
        return file_exists($fullPath);
    }
}

// Initialisation automatique
PathManager::init();
?>
