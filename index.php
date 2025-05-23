<?php
session_start(); // Démarrer la session pour vérifier si l'utilisateur est connecté
if (!isset($_SESSION["user_id"])) {
    // Si l'utilisateur n'est pas connecté, le rediriger vers la page de connexion
    header("Location: interface.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Voyage au Japon</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <style>
        .overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
        }
        #map-container {
            display: none;
            width: 100%;
            height: 500px;
            margin-top: 20px;
        }
    </style>
</head>
<body class="bg-gray-900 text-white">

<!-- Navbar -->
<nav class="fixed top-0 left-0 w-full bg-black bg-opacity-50 p-4 flex justify-between items-center z-50">
    <h1 class="text-xl font-bold">Voyage Japon</h1>
    <ul class="flex gap-6">
        <li><a href="#" class="hover:text-pink-200">Accueil</a></li>
        <li><a href="activites.php" class="hover:text-pink-200">Activités</a></li>
        <li><a href="hotels.php" class="hover:text-pink-200">Hôtels</a></li>
        <li><a href="reservation.php" class="hover:text-pink-200">Réservation</a></li>
        <li><button class="hover:text-pink-200" onclick="toggleMap(event)">Carte</button></li>
        <!-- Si l'utilisateur est connecté, afficher "Déconnexion" -->
        <?php if (isset($_SESSION["user_id"])): ?>
            <li><a href="deconnexion.php" class="hover:text-pink-200">Déconnexion</a></li>
        <?php endif; ?>
    </ul>
</nav>

<!-- Carte -->
<div id="map-container" class="w-full" style="display: none; margin-top: 64px; height: calc(100vh - 64px);">
    <iframe src="map.html" width="100%" height="100%" style="border: none;"></iframe>
</div>

<!-- Hero Section -->
<header class="relative h-screen flex items-center justify-center">
    <video autoplay loop muted class="absolute w-full h-full object-cover">
        <source src="japan-video.mp4" type="video/mp4" />
    </video>
    <div class="overlay"></div>
    <h1 class="text-5xl font-bold z-10 text-center">Explorez le Japon 🇯🇵</h1>
</header>

<!-- Destinations Populaires -->
<section class="p-10">
    <h2 class="text-3xl mb-6 text-center">🌏 Nos Destinations Populaires</h2>

    <div class="w-full flex justify-center">
        <div class="w-96 h-64 rounded-lg overflow-hidden shadow-lg">
            <div class="swiper mySwiper h-full">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <a href="reservation-tokyo.html">
                            <img src="images/tokyo1.jpg" alt="Tokyo 1" class="w-full h-full object-cover" />
                        </a>
                    </div>
                    <div class="swiper-slide">
                        <a href="reservation-tokyo.html">
                            <img src="images/tokyo2.jpg" alt="Tokyo 2" class="w-full h-full object-cover" />
                        </a>
                    </div>
                    <div class="swiper-slide">
                        <a href="reservation-tokyo.html">
                            <img src="images/tokyo3.jpg" alt="Tokyo 3" class="w-full h-full object-cover" />
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-black p-6 text-center">
    <p>© 2025 Voyage Japon. Tous droits réservés.</p>
</footer>

<script>
    // Carte toggle
    function toggleMap(event) {
        event.preventDefault();
        const mapContainer = document.getElementById("map-container");
        mapContainer.style.display = (mapContainer.style.display === "none" || mapContainer.style.display === "") ? "block" : "none";
    }

    // Cacher la carte si on clique ailleurs
    document.querySelectorAll("nav ul li a").forEach(link => {
        link.addEventListener("click", () => {
            document.getElementById("map-container").style.display = "none";
        });
    });
</script>

</body>
</html>

