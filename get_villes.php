<?php
require 'database.php';

$sql = "SELECT nom, latitude, longitude, description FROM villes";

$stmt = $pdo->query($sql);
$villes = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($villes);
?>

