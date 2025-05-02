<?php
// Afficher les erreurs
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'config.php';
// Connexion à la BDD
try {
    $pdo = new PDO("mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_NAME'] . ";charset=utf8", $_ENV['DB_USER'], $_ENV['DB_PASS']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Erreur de connexion : ' . $e->getMessage()]);
    exit;
}

// Vérifier si l'ID de la ville est envoyé
if (isset($_GET['city_id']) && !empty($_GET['city_id'])) {
    $cityId = (int) $_GET['city_id'];

    // Récupérer les coordonnées de la ville
    $stmt = $pdo->prepare('SELECT latitude, longitude FROM villes WHERE id = :city_id');
    $stmt->execute(['city_id' => $cityId]);
    $ville = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($ville) {
        $cityLat = $ville['latitude'];
        $cityLon = $ville['longitude'];

        // Requête pour récupérer les hôtels proches
        $stmt = $pdo->prepare('
            SELECT h.id, h.nom, h.latitude, h.longitude, 
            ( 6371 * acos( cos( radians(:city_lat) ) * cos( radians( h.latitude ) ) * cos( radians( h.longitude ) - radians(:city_lon) ) + sin( radians(:city_lat) ) * sin( radians( h.latitude ) ) ) ) AS distance
            FROM hotels h
            WHERE h.ville_id = :city_id
            HAVING distance < 50  -- Récupérer les hôtels dans un rayon de 50 km
            ORDER BY distance ASC
        ');
        $stmt->execute([
            'city_lat' => $cityLat,
            'city_lon' => $cityLon,
            'city_id' => $cityId
        ]);

        $hotels = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($hotels);
    } else {
        echo json_encode(['error' => 'Ville non trouvée.']);
    }
} else {
    echo json_encode(['error' => 'ID de ville manquant.']);
}
?>
