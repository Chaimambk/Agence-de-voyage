<?php
session_start();
require 'database.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["email"]) && isset($_POST["mot_de_passe"])) { // Formulaire de connexion
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
    } elseif (isset($_POST["nom"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["confirm_password"])) { // Formulaire d'inscription
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
    <style>
        /* Style global de la page */
        body {
            background-color: #121212;
            color: white;
            font-family: Arial, sans-serif;
        }

        /* Centre le formulaire dans la page */
        .centered-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Style de la carte contenant le formulaire */
        .form-card {
            background-color: #1f1f1f;
            color: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.6);
            width: 100%;
            max-width: 400px;
        }

        .form-card h2 {
            text-align: center;
            margin-bottom: 20px;
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
            background-color: #ff4d4d;
            padding: 15px;
            width: 100%;
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        .form-card button:hover {
            background-color: #ff3d3d;
        }

        .form-card p {
            text-align: center;
            margin-top: 15px;
        }

        .form-card .switch-form {
            color: #50c878;
            cursor: pointer;
            text-decoration: underline;
        }

        .form-card .error-message {
            color: #ff4d4d;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="centered-container">
    <div class="form-card">
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
        </form>

        <p class="mt-4">
            <span id="toggleForm" class="switch-form">Créer un compte</span>
        </p>
    </div>
</div>

<script>
    // Changer entre les formulaires de connexion et d'inscription
    document.getElementById("toggleForm").addEventListener("click", function(event) {
        event.preventDefault();
        const loginForm = document.getElementById("loginForm");
        const registerForm = document.getElementById("registerForm");
        const formTitle = document.getElementById("formTitle");
        const toggleFormText = document.getElementById("toggleForm");

        if (loginForm.classList.contains("hidden")) {
            loginForm.classList.remove("hidden");
            registerForm.classList.add("hidden");
            formTitle.textContent = "Connexion";
            toggleFormText.textContent = "Créer un compte";
        } else {
            loginForm.classList.add("hidden");
            registerForm.classList.remove("hidden");
            formTitle.textContent = "Inscription";
            toggleFormText.textContent = "Déjà un compte ? Se connecter";
        }
    });
</script>

</body>
</html>

