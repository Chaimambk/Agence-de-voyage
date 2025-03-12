<?php
require 'database.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = htmlspecialchars($_POST["nom"]);
    $email = htmlspecialchars($_POST["email"]);
    $password = $_POST["mot_de_passe"];

    // Vérifier si l'email existe déjà
    $check = $pdo->prepare("SELECT id FROM utilisateurs WHERE email = ?");
    $check->execute([$email]);

    if ($check->rowCount() > 0) {
        $message = "❌ Cet email est déjà utilisé !";
    } else {
        // Hasher le mot de passe avant de l'enregistrer
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insérer l'utilisateur en base
        $stmt = $pdo->prepare("INSERT INTO utilisateurs (nom, email, mot_de_passe) VALUES (?, ?, ?)");
        if ($stmt->execute([$nom, $email, $hashedPassword])) {
            $message = "✅ Inscription réussie ! Vous pouvez maintenant vous connecter.";
        } else {
            $message = "❌ Erreur lors de l'inscription.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card mx-auto" style="max-width: 400px;">
        <div class="card-body">
            <h3 class="text-center">Inscription</h3>

            <?php if ($message): ?>
                <div class="alert alert-info text-center"><?= $message ?></div>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="mb-3">
                    <label class="form-label">Nom</label>
                    <input type="text" name="nom" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mot de passe</label>
                    <input type="password" name="mot_de_passe" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">S'inscrire</button>
            </form>

            <p class="mt-3 text-center">
                Déjà un compte ? <a href="connexion.php">Se connecter</a>
            </p>
        </div>
    </div>
</div>

</body>
</html>
