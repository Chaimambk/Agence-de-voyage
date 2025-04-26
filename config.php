<?php

// Fonction pour charger les variables d'environnement depuis le fichier .env
function loadEnv() {
    // Chemin vers le fichier .env
    $envFile = '.env';

    // Vérifier si le fichier .env existe
    if (file_exists($envFile)) {
        // Lire toutes les lignes du fichier .env
        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        // Parcourir chaque ligne du fichier
        foreach ($lines as $line) {
            // Ignorer les lignes de commentaires (commençant par #)
            if (strpos($line, '#') === 0) continue;

            // Supprimer les guillemets autour des valeurs si présents
            $line = str_replace("'", "", $line);

            // Séparer la clé et la valeur par le signe égal (=)
            list($key, $value) = explode('=', $line, 2);

            // Ajouter la variable à $_ENV, en enlevant les espaces inutiles
            $_ENV[trim($key)] = trim($value);
        }
    } else {
        // Si le fichier .env n'existe pas, afficher un message d'erreur
        die('Fichier .env non trouvé!');
    }
}

// Charger les variables d'environnement
loadEnv();

// Vérifier les variables d'environnement (optionnel, à retirer une fois que tout fonctionne)
//print_r($_ENV);

// Exemple d'utilisation des variables d'environnement
$dbHost = $_ENV['DB_HOST'];
$dbName = $_ENV['DB_NAME'];
$dbUser = $_ENV['DB_USER'];
$dbPass = $_ENV['DB_PASS'];

// Connexion à la base de données avec PDO
try {
    // Créer une instance PDO pour la connexion à la base de données
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);

    // Définir le mode d'erreur de PDO pour afficher les erreurs SQL
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // echo "Connexion réussie à la base de données!";
} catch (PDOException $e) {
    // Si la connexion échoue, afficher le message d'erreur
    echo "Erreur de connexion : " . $e->getMessage();
}

?>
