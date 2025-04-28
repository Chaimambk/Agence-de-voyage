<?php
session_start();
require 'database.php';
global $pdo;

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["email"]) && isset($_POST["mot_de_passe"])) {
        $email = htmlspecialchars($_POST["email"]);
        $password = $_POST["mot_de_passe"];

        $stmt = $pdo->prepare("SELECT id, nom, mot_de_passe FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user["mot_de_passe"])) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_name"] = $user["nom"];
            header("Location: dashboard.php");
            exit();
        } else {
            $message = "❌ Email ou mot de passe incorrect.";
        }
    } elseif (isset($_POST["nom"], $_POST["email"], $_POST["password"], $_POST["confirm_password"])) {
        $nom = trim($_POST["nom"]);
        $email = trim($_POST["email"]);
        $password = $_POST["password"];
        $confirm_password = $_POST["confirm_password"];

        if (empty($nom) || empty($email) || empty($password) || empty($confirm_password)) {
            $message = "❌ Tous les champs sont obligatoires.";
        } elseif ($password !== $confirm_password) {
            $message = "❌ Les mots de passe ne correspondent pas.";
        } else {
            $stmt = $pdo->prepare("SELECT id FROM utilisateurs WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetch()) {
                $message = "❌ Cet email est déjà utilisé.";
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, email, mot_de_passe) VALUES (?, ?, ?)");
                if ($stmt->execute([$nom, $email, $hashed_password])) {
                    header("Location: authentification.php?success=1");
                    exit();
                } else {
                    $message = "❌ Une erreur est survenue.";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion / Inscription | Agence de Voyage</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #121212;
            color: white;
            font-family: Arial, sans-serif;
        }
        .centered-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .form-card {
            background-color: #1f1f1f;
            color: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.6);
            width: 100%;
            max-width: 400px;
            position: relative;
            overflow: hidden;
        }
        .logo-bounce {
            animation: bounce 2s infinite;
            font-size: 50px;
            color: #c184c0;
            text-align: center;
            margin-bottom: 20px;
        }
        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }
        .form-card h2 {
            text-align: center;
            margin-bottom: 10px;
            font-size: 24px;
        }
        .form-card input {
            background-color: #333;
            border: 1px solid #444;
            padding: 15px;
            margin-bottom: 15px;
            width: 100%;
            border-radius: 8px;
            color: white;
            font-size: 16px;
        }
        .form-card button {
            background-color: #c184c0;
            padding: 15px;
            width: 100%;
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.2s, background-color 0.3s;
        }
        .form-card button:hover {
            background-color: #c86bae;
            transform: scale(1.05);
        }
        .form-card p {
            text-align: center;
            margin-top: 15px;
        }
        .form-card .switch-form {
            color: #ece5ea;
            cursor: pointer;
            text-decoration: underline;
        }
        .form-card .error-message {
            color: #c86bae;
            text-align: center;
            margin-bottom: 10px;
        }
        .social-icons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }
        .social-icons a {
            color: #c184c0;
            font-size: 24px;
            transition: transform 0.3s;
        }
        .social-icons a:hover {
            transform: scale(1.2);
            color: #c86bae;
        }
        .fade-in {
            opacity: 0;
            animation: fadeIn 0.5s forwards;
        }
        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="fixed top-0 left-0 w-full bg-black bg-opacity-50 p-4 flex justify-between items-center z-50">
    <h1 class="text-xl font-bold">Voyage Japon</h1>
    <ul class="flex gap-6">
        <li><a href="#" class="hover:text-red-200">Accueil</a></li>
        <li><a href="villes.html" class="hover:text-red-200">Villes</a></li>
        <li><a href="hotels.php" class="hover:text-red-200">Hôtels</a></li>
        <li><a href="reservation.php" class="hover:text-red-200">Réservation</a></li>
        <li><button class="hover:text-red-200" onclick="toggleMap(event)">Carte</button></li>
        <li><a href="authentification.php" class="hover:text-red-200" onclick="toggleAuthModal()">Connexion</a></li>
    </ul>
</nav>

<div class="centered-container">
    <div class="form-card">

        <!-- Logo animé -->
        <div class="logo-bounce">
            <i class="fa-solid fa-earth-asia"></i>
        </div>

        <h2 id="formTitle">Connexion</h2>

        <?php if ($message): ?>
            <p class="error-message"><?php echo $message; ?></p>
        <?php endif; ?>

        <!-- Formulaire Connexion -->
        <form id="loginForm" action="authentification.php" method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="mot_de_passe" placeholder="Mot de passe" required>
            <button type="submit">Se connecter</button>
        </form>

        <!-- Formulaire Inscription -->
        <form id="registerForm" action="authentification.php" method="POST" class="hidden">
            <input type="text" name="nom" placeholder="Nom" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Mot de passe" required>
            <input type="password" name="confirm_password" placeholder="Confirmez le mot de passe" required>
            <button type="submit">S'inscrire</button>

            <!-- Icônes sociales -->
            <div class="social-icons">
                <a href="#"><i class="fab fa-google"></i></a>
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-apple"></i></a>
            </div>
        </form>

        <p class="mt-4" id="switchContainer">
            Pas encore inscrit ? <span id="toggleForm" class="switch-form">Créer un compte</span>
        </p>
    </div>
</div>

<script>
    function switchForms(event) {
        event.preventDefault();
        const loginForm = document.getElementById("loginForm");
        const registerForm = document.getElementById("registerForm");
        const formTitle = document.getElementById("formTitle");
        const switchContainer = document.getElementById("switchContainer");

        if (loginForm.classList.contains("hidden")) {
            loginForm.classList.remove("hidden");
            registerForm.classList.add("hidden");
            loginForm.classList.add("fade-in");
            formTitle.innerHTML = "Connexion";
            formTitle.classList.add("fade-in");
            switchContainer.innerHTML = 'Pas encore inscrit ? <span id="toggleForm" class="switch-form">Créer un compte</span>';
        } else {
            loginForm.classList.add("hidden");
            registerForm.classList.remove("hidden");
            registerForm.classList.add("fade-in");
            formTitle.innerHTML = 'Inscription<br><span class="text-sm text-gray-400">Rejoins-nous 🌍</span>';
            formTitle.classList.add("fade-in");
            switchContainer.innerHTML = 'Déjà un compte ? <span id="toggleForm" class="switch-form">Se connecter</span>';
        }
        document.getElementById("toggleForm").addEventListener("click", switchForms);
    }

    // Premier attachement
    document.getElementById("toggleForm").addEventListener("click", switchForms);

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
</script>

</body>
</html>