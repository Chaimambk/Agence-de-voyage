<?php
require 'config.php';
/*
$host = '127.0.0.1';  // Serveur
$dbname = 'Prog_Web_Php';  // Nom de ta base de données
$username = 'root';  // Nom d'utilisateur MySQL
$password = 'rootroot';  // Mot de passe (laisser vide si aucun)
*/
try {
    $pdo = new PDO("mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_NAME'] . ";charset=utf8", $_ENV['DB_USER'], $_ENV['DB_PASS']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
// "mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password