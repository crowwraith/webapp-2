<?php
$servername = "mysql_db";
$username = "root";
$password = "rootpassword";

try {
    $conn = new PDO("mysql:host=$servername;dbname=reisbureau", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Verbinding mislukt: " . $e->getMessage();
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "UPDATE menu SET title = :title, prijs = :prijs, omschrijving = :omschrijving WHERE id = :id";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $_POST['id']);
    $stmt->bindParam(':title', $_POST['title']);
    $stmt->bindParam(':prijs', $_POST['prijs']);
    $stmt->bindParam(':omschrijving', $_POST['omschrijving']);
    $stmt->execute();

    echo "<p>Ries bijgewerkt!</p>";
}

$menu = $conn->query("SELECT * FROM menu")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Bewerk je menu</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .gerecht { border: 1px solid #ccc; padding: 10px; margin-bottom: 10px; }
        input[type=text], input[type=number], textarea { width: 100%; margin-bottom: 5px; }
        input[type=submit] { padding: 5px 10px; }
    </style>
</head>
<body>
<h1>Bewerk hier je gerechten</h1>

<?php foreach ($menu as $item): ?>
    <div class="gerecht">
        <form method="POST">
            <input type="hidden" name="id" value="<?= $item['id'] ?>">

            <label>Titel: </label>
            <input type="text" name="title" value="<?= $item['title'] ?>" required>

            <label>Prijs (€): </label>
            <input type="number" name="prijs" step="0.01" value="<?= $item['prijs'] ?>" required>

            <label>Omschrijving: </label>
            <textarea name="omschrijving" rows="2"><?= $item['omschrijving'] ?></textarea>

            <input type="submit" value="Opslaan">
        </form>
    </div>
<?php endforeach; ?>
</body>
</html>
