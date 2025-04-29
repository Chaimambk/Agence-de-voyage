<?php
session_start(); // Démarrer la session
session_unset(); // Supprimer toutes les variables de session
session_destroy(); // Détruire la session
header("Location: interface.html"); // Rediriger vers la page d'accueil
exit();
?>


