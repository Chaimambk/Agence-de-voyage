<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voyage au Japon</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <style>
        /* Effet sombre sur le texte de la vidéo */
        .overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
        }
        /* Styles Swiper */
        .swiper-slide img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 10px;
        }
    </style>
</head>
<body class="bg-gray-900 text-white">

<!-- Navbar -->
<nav class="fixed top-0 left-0 w-full bg-black bg-opacity-50 p-4 flex justify-between items-center z-50">
    <h1 class="text-xl font-bold">Voyage Japon</h1>
    <ul class="flex gap-6">
        <li><a href="#" class="hover:text-red-500">Accueil</a></li>
        <li><a href="villes.html" class="hover:text-red-500">Villes</a></li>
        <li><a href="hotels.html" class="hover:text-red-500">Hôtels</a></li>
        <li><a href="reservation.html" class="hover:text-red-500">Réservation</a></li>
    </ul>
</nav>

<!-- Hero Section avec Vidéo -->
<header class="relative h-screen flex items-center justify-center">
    <video autoplay loop muted class="absolute w-full h-full object-cover">
        <source src="japan-video.mp4" type="video/mp4">
    </video>
    <div class="overlay"></div>
    <h1 class="text-5xl font-bold z-10 text-center">Explorez le Japon 🇯🇵</h1>
</header>

<!-- Section Villes Populaires -->
<section class="p-10">
    <h2 class="text-3xl mb-6 text-center">🌟 Nos Destinations Populaires</h2>
    <div class="swiper mySwiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide"><img src="tokyo.jpg" alt="Tokyo"></div>
            <div class="swiper-slide"><img src="kyoto.jpg" alt="Kyoto"></div>
            <div class="swiper-slide"><img src="osaka.jpg" alt="Osaka"></div>
        </div>
    </div>
</section>

<!-- Section Activités -->
<section class="p-10 bg-gray-800">
    <h2 class="text-3xl mb-6 text-center">🚀 Activités à Découvrir</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-4 text-black rounded-lg shadow-lg">
            <img src="temple.jpg" class="rounded-lg mb-3" alt="Temple Japonais">
            <h3 class="text-xl font-bold">Visite de Temples</h3>
            <p>Découvrez la beauté des temples ancestraux du Japon.</p>
        </div>
        <div class="bg-white p-4 text-black rounded-lg shadow-lg">
            <img src="sushi.jpg" class="rounded-lg mb-3" alt="Sushi">
            <h3 class="text-xl font-bold">Cours de Sushi</h3>
            <p>Apprenez à faire des sushis avec des chefs japonais !</p>
        </div>
        <div class="bg-white p-4 text-black rounded-lg shadow-lg">
            <img src="onsen.jpg" class="rounded-lg mb-3" alt="Onsen">
            <h3 class="text-xl font-bold">Bains Onsen</h3>
            <p>Profitez des sources thermales relaxantes du Japon.</p>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="bg-black p-6 text-center">
    <p>© 2025 Voyage Japon. Tous droits réservés.</p>
</footer>

<script>
    // Animations GSAP
    gsap.from("h1", { opacity: 0, y: -50, duration: 1, ease: "power2.out" });
    gsap.from("nav", { opacity: 0, y: -50, duration: 1, delay: 0.5 });

    // Swiper
    const swiper = new Swiper(".mySwiper", {
        loop: true,
        autoplay: { delay: 3000 },
        slidesPerView: 1,
        breakpoints: {
            640: { slidesPerView: 2 },
            1024: { slidesPerView: 3 }
        }
    });
</script>

</body>
</html>
