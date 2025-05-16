<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Connexion BDD
require 'config.php';

try {
    $pdo = new PDO("mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_NAME'] . ";charset=utf8", $_ENV['DB_USER'], $_ENV['DB_PASS']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}

// Vérification des données du formulaire
if (
    !isset($_POST['hotel'], $_POST['chambre'], $_POST['checkin'], $_POST['checkout'], $_POST['guests'])
) {
    header('Location: reservation.php?error=Tous les champs sont requis.');
    exit;
}

$hotelId = intval($_POST['hotel']);
$chambreId = intval($_POST['chambre']);
$checkin = $_POST['checkin'];
$checkout = $_POST['checkout'];
$guests = intval($_POST['guests']);



// Vérification de la disponibilité de la chambre
$sql = "
    SELECT COUNT(*) FROM reservations
    WHERE chambre_id = :chambre_id
    AND NOT (
        :checkout <= date_debut OR
        :checkin >= date_fin
    )
";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    'chambre_id' => $chambreId,
    'checkin' => $checkin,
    'checkout' => $checkout
]);
$nbConflits = $stmt->fetchColumn();

if ($nbConflits > 0) {
    header('Location: reservation.php?error=Cette chambre est déjà réservée pour ces dates.');
    exit;
}

// Insérer la réservation dans la table reservations
$stmt = $pdo->prepare("
    INSERT INTO reservations (chambre_id, date_debut, date_fin, nb_personnes)
    VALUES (:chambre_id, :date_debut, :date_fin, :nb_personnes)
");

$stmt->execute([
    'chambre_id' => $chambreId,
    'date_debut' => $checkin,
    'date_fin' => $checkout,
    'nb_personnes' => $guests
]);

header('Location: reservation.php?success=Réservation effectuée avec succès.');
exit;
?>
