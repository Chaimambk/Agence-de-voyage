<?php
// Activer les erreurs pour le debug
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Connexion BDD
require 'config.php';

try {
    $pdo = new PDO("mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_NAME'] . ";charset=utf8", $_ENV['DB_USER'], $_ENV['DB_PASS']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur de connexion BDD']);
    exit;
}

// Vérifier les paramètres
if (!isset($_GET['hotel_id'], $_GET['checkin'], $_GET['checkout'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Paramètres manquants']);
    exit;
}

$hotelId = intval($_GET['hotel_id']);
$checkin = $_GET['checkin'];
$checkout = $_GET['checkout'];

// Requête pour récupérer les chambres disponibles
$sql = "
    SELECT chambres.id, chambres.nom, chambres.capacite, chambres.type
    FROM chambres
    WHERE chambres.hotel_id = :hotel_id
    AND chambres.id NOT IN (
        SELECT chambre_id
        FROM reservations
        WHERE NOT (
            :checkout <= date_debut OR
            :checkin >= date_fin
        )
    )
";

$stmt = $pdo->prepare($sql);
$stmt->execute([
    'hotel_id' => $hotelId,
    'checkin' => $checkin,
    'checkout' => $checkout
]);

$chambres = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Retour JSON
header('Content-Type: application/json');
echo json_encode($chambres);
