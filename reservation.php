<?php
// Connexion BDD
error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'config.php';
try {
    $pdo = new PDO("mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_NAME'] . ";charset=utf8", $_ENV['DB_USER'], $_ENV['DB_PASS']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}

// Récupération de toutes les villes
$villes = $pdo->query('SELECT id, nom FROM villes')->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Réservation - Voyage au Japon</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Flatpickr CSS et JS -->
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</head>
<body class="bg-gray-900 text-white">

<!-- Navbar -->
<nav class="fixed top-0 left-0 w-full bg-black bg-opacity-50 p-4 flex justify-between items-center z-50">
    <h1 class="text-xl font-bold">Voyage Japon</h1>
    <ul class="flex gap-6">
        <li><a href="interface.html" class="hover:text-pink-200">Accueil</a></li>
        <li><a href="villes.php" class="hover:text-pink-200">Villes</a></li>
        <li><a href="hotels.php" class="hover:text-pink-200">Hôtels</a></li>
        <li><a href="reservation.php" class="hover:text-pink-200">Réservation</a></li>
        <li><button class="hover:text-pink-200" onclick="toggleMap()">Carte</button></li>
        <li><a href="authentification.php" class="hover:text-pink-200" onclick="toggleAuthModal()">Connexion</a></li>
    </ul>
</nav>

<!-- Formulaire -->
<section id="reservation-section" class="p-10 mt-24">
    <h2 class="text-3xl mb-6 text-center">🌸 Réservez votre séjour 🌸 </h2>

    <div class="w-full flex justify-center">
        <div class="w-full max-w-4xl bg-gray-800 rounded-lg shadow-lg p-8">
            <form action="traitement_reservation.php" method="POST">
                <!-- Ville -->
                <div class="mb-6">
                    <label for="city" class="block text-lg font-medium mb-2">Choisissez une Ville :</label>
                    <select id="city" name="city" class="w-full p-3 bg-gray-700 text-white rounded-lg" onchange="loadHotels()" required>
                        <option value="">Sélectionnez une ville</option>
                        <?php foreach ($villes as $ville): ?>
                            <option value="<?= htmlspecialchars($ville['id']) ?>">
                                <?= htmlspecialchars($ville['nom']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Hôtel -->
                <div class="mb-6">
                    <label for="hotel" class="block text-lg font-medium mb-2">Choisissez un Hôtel :</label>
                    <select id="hotel" name="hotel" class="w-full p-3 bg-gray-700 text-white rounded-lg" required>
                        <option value="">Sélectionnez d'abord une ville</option>
                    </select>
                </div>

                <!-- Dates -->
                <div class="mb-6">
                    <label for="checkin" class="block text-lg font-medium mb-2">Date d'Arrivée :</label>
                    <input type="text" id="checkin" name="checkin" class="w-full p-3 bg-gray-700 text-white rounded-lg" required>
                </div>

                <div class="mb-6">
                    <label for="checkout" class="block text-lg font-medium mb-2">Date de Départ :</label>
                    <input type="text" id="checkout" name="checkout" class="w-full p-3 bg-gray-700 text-white rounded-lg" required>
                </div>

                <!-- Nombre de personnes -->
                <div class="mb-6">
                    <label for="guests" class="block text-lg font-medium mb-2">Nombre de Personnes :</label>
                    <input type="number" id="guests" name="guests" min="1" max="10" class="w-full p-3 bg-gray-700 text-white rounded-lg" required>
                </div>

                <!-- Bouton -->
                <div class="mb-6 text-center">
                    <button type="submit" class="w-full bg-pink-200 hover:bg-pink-300 text-white p-4 rounded-lg">
                        Réserver
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-black p-6 text-center mt-24">
    <p>© 2025 Voyage Japon. Tous droits réservés.</p>
</footer>

<!-- JS pour charger les hôtels en fonction de la ville sélectionnée -->
<script>
    function loadHotels() {
        const cityId = document.getElementById('city').value;
        const hotelSelect = document.getElementById('hotel');

        hotelSelect.innerHTML = '<option>Chargement...</option>';

        if (cityId) {
            fetch('get_hotels.php?city_id=' + cityId)
                .then(response => response.json())
                .then(data => {
                    hotelSelect.innerHTML = '<option value="">Sélectionnez un hôtel</option>';

                    // Ajouter les hôtels sans doublons
                    const seen = new Set(); // Utiliser un Set pour éviter les doublons
                    data.forEach(hotel => {
                        if (!seen.has(hotel.id)) { // Vérifier si l'hôtel a déjà été ajouté
                            const option = document.createElement('option');
                            option.value = hotel.id;
                            option.textContent = hotel.nom;
                            hotelSelect.appendChild(option);
                            seen.add(hotel.id); // Marquer cet hôtel comme ajouté
                        }
                    });
                })
                .catch(error => {
                    console.error('Erreur lors du chargement des hôtels:', error);
                    hotelSelect.innerHTML = '<option>Erreur</option>';
                });
        } else {
            hotelSelect.innerHTML = '<option value="">Sélectionnez d\'abord une ville</option>';
        }
    }

    // Fonction pour afficher/masquer la carte
    function toggleMap() {
        const mapContainer = document.getElementById("map-container");
        const reservationSection = document.getElementById("reservation-section");

        // Si la carte est cachée, on l'affiche, sinon on la cache
        if (mapContainer.style.display === "none" || mapContainer.style.display === "") {
            mapContainer.style.display = "block"; // Afficher la carte
            reservationSection.style.display = "none"; // Masquer le formulaire
        } else {
            mapContainer.style.display = "none"; // Masquer la carte
            reservationSection.style.display = "block"; // Afficher le formulaire
        }
    }

    // Connexion modal toggle
    function toggleAuthModal() {
        document.getElementById("auth-modal").classList.toggle("hidden");
    }
</script>

<!-- Carte -->
<div id="map-container" class="w-full" style="display: none; margin-top: 64px; height: calc(100vh - 64px);">
    <button onclick="toggleMap()" class="bg-pink-200 text-white p-4 rounded-lg absolute top-4 right-4 z-50">Fermer la carte</button>
    <iframe src="map.html" width="100%" height="100%" style="border: none;"></iframe>
</div>

<!-- JS pour Flatpickr -->
<script>
    // Initialisation de Flatpickr pour les dates
    flatpickr("#checkin", {
        minDate: "today", // Limite la date à aujourd'hui
        dateFormat: "Y-m-d", // Format de la date
        disableMobile: true, // Désactive la version mobile si nécessaire
    });

    flatpickr("#checkout", {
        minDate: "today", // Limite la date à aujourd'hui
        dateFormat: "Y-m-d", // Format de la date
        disableMobile: true, // Désactive la version mobile si nécessaire
    });
</script>

</body>
</html>
