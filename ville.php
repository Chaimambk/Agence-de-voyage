$stmt = $pdo->query("SELECT * FROM villes LIMIT 5");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
echo $row['nom'] . "<br>";
}
