<?php
require 'config.php';
try {
    $pdo = new PDO("mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_NAME'] . ";charset=utf8", $_ENV['DB_USER'], $_ENV['DB_PASS']);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Requête pour récupérer les activités avec le nom des villes
$sql = "SELECT a.*, v.nom AS ville_nom 
        FROM activites a
        JOIN villes v ON a.ville_id = v.id";
$stmt = $pdo->query($sql);
$activites = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Activités au Japon</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white">

<!-- Navbar -->
<nav class="fixed top-0 left-0 w-full bg-black bg-opacity-50 p-4 flex justify-between items-center z-50">
    <h1 class="text-xl font-bold">Voyage Japon</h1>
    <ul class="flex gap-6">
        <li><a href="interface.html" class="hover:text-pink-200">Accueil</a></li>
        <li><a href="activites.php" class="hover:text-pink-200">Activités</a></li>
        <li><a href="hotels.php" class="hover:text-pink-200">Hôtels</a></li>
        <li><a href="reservation.php" class="hover:text-pink-200">Réservation</a></li>
        <li><button class="hover:text-pink-200" onclick="toggleMap(event)">Carte</button></li>
        <li><a href="authentification.php" class="hover:text-pink-200">Connexion</a></li>
    </ul>
</nav>

<!-- Titre -->
<h1 class="text-3xl text-center mt-32 mb-10 font-bold">Activités disponibles au Japon 🇯🇵</h1>

<!-- Grille des activités -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 px-8 pb-20 max-w-7xl mx-auto">
    <?php foreach ($activites as $activite): ?>
        <div class="bg-gray-800 p-6 rounded-lg shadow-lg flex flex-col items-center text-center">
            <img src="images/<?= htmlspecialchars($activite['image']) ?>" alt="<?= htmlspecialchars($activite['nom']) ?>" class="w-full h-48 object-cover rounded-lg mb-4">
            <h2 class="text-xl font-semibold"><?= htmlspecialchars($activite['nom']) ?></h2>
            <p class="text-sm italic text-gray-400 mt-1">Ville : <?= htmlspecialchars($activite['ville_nom']) ?></p>
            <p class="mt-2"><?= htmlspecialchars($activite['description']) ?></p>
            <p class="text-pink-300 font-bold mt-2">
                <?= $activite['prix'] == 0 ? 'Gratuit' : htmlspecialchars($activite['prix']) . ' €' ?>
            </p>

        </div>
    <?php endforeach; ?>
</div>

<!-- Footer -->
<footer class="bg-black p-6 text-center">
    <p>© 2025 Voyage Japon. Tous droits réservés.</p>
</footer>

</body>
</html>
