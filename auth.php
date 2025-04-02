<?php
// database.php (à inclure dans chaque fichier nécessitant une connexion à la base de données)
$host = 'localhost';
$dbname = 'voyage_japon';
$username = 'root';
$password = 'rootroot';
require 'database.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>

<!-- Fenêtre modale de connexion/inscription (à inclure dans index.php) -->
<div id="auth-modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white text-black p-6 rounded-lg w-96 relative">
        <button onclick="closeAuthModal()" class="absolute top-2 right-2 text-xl">&times;</button>
        <h2 id="authTitle" class="text-2xl font-bold mb-4 text-center">Connexion</h2>

        <!-- Formulaire de Connexion -->
        <form id="loginForm" action="connexion.php" method="POST">
            <input type="email" name="email" placeholder="Email" class="w-full p-2 border mb-2" required>
            <input type="password" name="mot_de_passe" placeholder="Mot de passe" class="w-full p-2 border mb-2" required>
            <button type="submit" class="bg-red-500 text-white w-full p-2">Se connecter</button>
        </form>

        <!-- Formulaire d'Inscription (caché par défaut) -->
        <form id="registerForm" action="inscription.php" method="POST" class="hidden">
            <input type="text" name="nom" placeholder="Nom" class="w-full p-2 border mb-2" required>
            <input type="email" name="email" placeholder="Email" class="w-full p-2 border mb-2" required>
            <input type="password" name="mot_de_passe" placeholder="Mot de passe" class="w-full p-2 border mb-2" required>
            <button type="submit" class="bg-green-500 text-white w-full p-2">S'inscrire</button>
        </form>

        <p class="text-center mt-4">
            <a href="#" id="toggleAuthForm" class="text-blue-500">Créer un compte</a>
        </p>
    </div>
</div>

<script>
    function openAuthModal() {
        document.getElementById("auth-modal").classList.remove("hidden");
    }
    function closeAuthModal() {
        document.getElementById("auth-modal").classList.add("hidden");
    }

    document.getElementById("toggleAuthForm").addEventListener("click", function(event) {
        event.preventDefault();
        const loginForm = document.getElementById("loginForm");
        const registerForm = document.getElementById("registerForm");
        const authTitle = document.getElementById("authTitle");

        if (loginForm.classList.contains("hidden")) {
            loginForm.classList.remove("hidden");
            registerForm.classList.add("hidden");
            authTitle.textContent = "Connexion";
            this.textContent = "Créer un compte";
        } else {
            loginForm.classList.add("hidden");
            registerForm.classList.remove("hidden");
            authTitle.textContent = "Inscription";
            this.textContent = "Déjà un compte ? Se connecter";
        }
    });
</script>
