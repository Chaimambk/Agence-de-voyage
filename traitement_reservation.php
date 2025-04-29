<?php
// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id'])) {
    die('Erreur : Utilisateur non connecté.');
}

// Récupérer l'ID de l'utilisateur connecté
$utilisateurId = $_SESSION['id'];

// Connexion à la base de données
require 'config.php';
try {
    $pdo = new PDO("mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_NAME'] . ";charset=utf8", $_ENV['DB_USER'], $_ENV['DB_PASS']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}

// Récupérer les données du formulaire
$cityId = $_POST['city'];
$hotelId = $_POST['hotel'];
$checkinDate = $_POST['checkin'];
$checkoutDate = $_POST['checkout'];
$guests = $_POST['guests'];

// Validation des dates
if (strtotime($checkinDate) >= strtotime($checkoutDate)) {
    die('Erreur : La date de départ doit être après la date d\'arrivée.');
}

// Insertion de la réservation dans la base de données
try {
    // Requête d'insertion dans la table des réservations
    $stmt = $pdo->prepare("INSERT INTO reservations (utilisateur_id, city_id, hotel_id, checkin_date, checkout_date, guests) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$utilisateurId, $cityId, $hotelId, $checkinDate, $checkoutDate, $guests]);

    echo "Réservation effectuée avec succès !";
} catch (PDOException $e) {
    die('Erreur lors de l\'insertion : ' . $e->getMessage());
}
?>
