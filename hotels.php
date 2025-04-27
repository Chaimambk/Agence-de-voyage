<?php
require 'config.php';
try {
    $pdo = new PDO("mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_NAME'] . ";charset=utf8", $_ENV['DB_USER'], $_ENV['DB_PASS']);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Requête pour récupérer les hôtels avec les noms de ville
$sql = "SELECT h.*, v.nom AS ville_nom 
        FROM hotels h 
        JOIN villes v ON h.ville_id = v.id";
$stmt = $pdo->query($sql);
$hotels = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nos Hôtels au Japon</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- SwiperJS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"/>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
</head>
<body class="bg-gray-900 text-white">

<!-- Navbar -->
<nav class="fixed top-0 left-0 w-full bg-black bg-opacity-50 p-4 flex justify-between items-center z-50">
    <h1 class="text-xl font-bold">Voyage Japon</h1>
    <ul class="flex gap-6">
        <li><a href="interface.html" class="hover:text-red-500">Accueil</a></li>
        <li><a href="villes.html" class="hover:text-red-500">Villes</a></li>
        <li><a href="hotels.php" class="hover:text-red-500">Hôtels</a></li>
        <li><a href="reservation.php" class="hover:text-red-500">Réservation</a></li>
        <li><a href="auth.php" class="hover:text-red-500">Connexion</a></li>
    </ul>
</nav>

<!-- Titre principal -->
<h1 class="text-3xl text-center mt-32 mb-10 font-bold">Nos Hôtels au Japon 🇯🇵</h1>

<!-- Swiper -->
<div class="swiper mySwiper w-11/12 max-w-5xl mx-auto pb-20">
    <div class="swiper-wrapper">
        <?php foreach ($hotels as $hotel): ?>
            <div class="swiper-slide bg-gray-800 rounded-lg p-6 shadow-lg flex flex-col items-center">
                <img src="images/<?= htmlspecialchars($hotel['image']) ?>" alt="<?= htmlspecialchars($hotel['nom']) ?>" class="w-full h-60 object-cover rounded-lg">
                <div class="hotel-info mt-4 text-center">
                    <h2 class="text-2xl font-semibold"><?= htmlspecialchars($hotel['nom']) ?></h2>
                    <h4 class="text-sm italic text-gray-400 mt-1">Ville : <?= htmlspecialchars($hotel['ville_nom']) ?></h4>
                    <p class="mt-2"><?= htmlspecialchars($hotel['description']) ?></p>
                    <p class="text-sm text-gray-300 mt-2"><?= htmlspecialchars($hotel['adresse']) ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Flèches -->
    <div class="swiper-button-next text-white"></div>
    <div class="swiper-button-prev text-white"></div>
</div>

<!-- Footer -->
<footer class="bg-black p-6 text-center">
    <p>© 2025 Voyage Japon. Tous droits réservés.</p>
</footer>

<!-- Swiper JS Config -->
<script>
    const swiper = new Swiper('.mySwiper', {
        slidesPerView: 1,
        spaceBetween: 30,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        loop: true,
    });
</script>

</body>
</html>
