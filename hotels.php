<?php
// Connexion à la base de données
$host = '127.0.0.1';
$dbname = 'Prog_Web_Php';
$user = 'root';
$pass = 'rootroot';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
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
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css"/>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <style>
        body {
            background-color: #111827;
            color: white;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 2rem;
        }

        h1 {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 2rem;
        }

        .swiper {
            width: 90%;
            max-width: 1000px;
            margin: auto;
        }

        .swiper-slide {
            background: #1f2937;
            border-radius: 1rem;
            padding: 1rem;
            text-align: center;
            box-shadow: 0 0 15px rgba(0,0,0,0.3);
        }

        .swiper-slide img {
            width: 100%;
            max-height: 300px;
            object-fit: cover;
            border-radius: 1rem;
        }

        .hotel-info {
            margin-top: 1rem;
        }

        .swiper-button-next,
        .swiper-button-prev {
            color: white;
        }
    </style>
</head>
<body>
<h1>Nos Hôtels au Japon 🇯🇵</h1>

<div class="swiper">
    <div class="swiper-wrapper">
        <?php foreach ($hotels as $hotel): ?>
            <div class="swiper-slide">
                <!-- Affichage de l'image de l'hôtel -->
                <img src="images/<?= htmlspecialchars($hotel['image']) ?>" alt="<?= htmlspecialchars($hotel['nom']) ?>">
                <div class="hotel-info">
                    <h2><?= htmlspecialchars($hotel['nom']) ?></h2>
                    <h4 class="text-sm italic text-gray-400">Ville : <?= htmlspecialchars($hotel['ville_nom']) ?></h4>
                    <p><?= htmlspecialchars($hotel['description']) ?></p>
                    <p class="text-sm text-gray-300 mt-2"><?= htmlspecialchars($hotel['adresse']) ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Flèches de navigation -->
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
</div>

<script>
    const swiper = new Swiper('.swiper', {
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
