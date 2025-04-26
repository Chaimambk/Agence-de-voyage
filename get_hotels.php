<?php
// Afficher les erreurs
error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'config.php';
// Connexion BDD
try {
    $pdo = new PDO("mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_NAME'] . ";charset=utf8", $_ENV['DB_USER'], $_ENV['DB_PASS']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Erreur de connexion : ' . $e->getMessage()]);
    exit;
}

// Vérifier si l'id de la ville est envoyé
if (isset($_GET['city_id']) && !empty($_GET['city_id'])) {
    $cityId = (int) $_GET['city_id'];

    try {
        $stmt = $pdo->prepare('SELECT DISTINCT id, nom FROM hotels WHERE ville_id = :city_id');
        $stmt->execute(['city_id' => $cityId]);
        $hotels = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($hotels);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Erreur lors de la récupération des hôtels : ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'ID de ville manquant.']);
}
?>
