<?php
require 'database.php';

$sql = "SELECT nom, latitude, longitude, description FROM hotels";
$stmt = $pdo->query($sql);
$hotels = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($hotels);
?>

