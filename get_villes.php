<?php
require 'database.php';

$sql = "SELECT id, nom, latitude, longitude, description FROM villes";  // Ajout de 'id'

$stmt = $pdo->query($sql);
$villes = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($villes);
?>
