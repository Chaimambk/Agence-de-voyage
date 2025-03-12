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
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card mx-auto" style="max-width: 400px;">
        <div class="card-body">
            <h3 class="text-center">Connexion</h3>

            <?php if ($message): ?>
                <div class="alert alert-danger text-center"><?= $message ?></div>
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
                <button type="submit" class="btn btn-primary w-100">Se connecter</button>
            </form>

            <p class="mt-3 text-center">
                Pas encore inscrit ? <a href="inscription.php">Créer un compte</a>
            </p>
        </div>
    </div>
</div>

</body>
</html>
