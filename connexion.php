<?php
session_start();
require 'database.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars($_POST["email"]);
    $password = $_POST["mot_de_passe"];

    // Vérifier si l'utilisateur existe
    $stmt = $pdo->prepare("SELECT id, nom, mot_de_passe FROM utilisateurs WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user["mot_de_passe"])) {
        // Connexion réussie, enregistrer l'utilisateur en session
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["user_name"] = $user["nom"];
        header("Location: dashboard.php"); // Redirige vers une page d'accueil après connexion
        exit();
    } else {
        $message = "❌ Email ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion | Voyage Japon</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <style>
        /* Personnalisation du style pour ta page */
        body {
            background-color: #1a202c;
            color: white;
        }
        .container {
            margin-top: 100px;
        }
        .alert {
            color: red;
        }
        .form-control {
            width: 100%;
            padding: 10px;
            background-color: #2d3748;
            border: 1px solid #4a5568;
            border-radius: 5px;
        }
        .btn {
            width: 100%;
            padding: 10px;
            background-color: #e53e3e;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
        }
        .btn:hover {
            background-color: #c53030;
        }
        .footer {
            background-color: #2d3748;
            color: white;
            padding: 10px;
            text-align: center;
            margin-top: 50px;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="fixed top-0 left-0 w-full bg-black bg-opacity-50 p-4 flex justify-between items-center z-50">
    <h1 class="text-xl font-bold">Voyage Japon</h1>
    <ul class="flex gap-6">
        <li><a href="#" class="hover:text-red-500">Accueil</a></li>
        <li><a href="villes.html" class="hover:text-red-500">Villes</a></li>
        <li><a href="hotels.html" class="hover:text-red-500">Hôtels</a></li>
        <li><a href="reservation.html" class="hover:text-red-500">Réservation</a></li>
        <li><button class="hover:text-red-500" onclick="toggleMap(event)">Carte</button></li>
        <li><a href="auth.php" class="hover:text-red-500" onclick="toggleAuthModal()">Connexion</a></li>
    </ul>
</nav>

<!-- Formulaire de Connexion -->
<div class="container">
    <div class="card mx-auto" style="max-width: 400px;">
        <div class="card-body">
            <h3 class="text-center">Connexion</h3>

            <?php if ($message): ?>
                <div class="alert text-center"><?= $message ?></div>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mot de passe</label>
                    <input type="password" name="mot_de_passe" class="form-control" required>
                </div>
                <button type="submit" class="btn">Se connecter</button>
            </form>

            <p class="mt-3 text-center">
                Pas encore inscrit ? <a href="inscription.php" class="text-blue-400 hover:underline">Créer un compte</a>
            </p>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="footer">
    <p>© 2025 Voyage Japon. Tous droits réservés.</p>
</footer>

</body>
</html>

