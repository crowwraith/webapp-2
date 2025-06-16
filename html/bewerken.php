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
    $sql = "UPDATE reisjes SET naam = :naam, datum = :datum, van_waar = :van_waar, status = :status, transfer = :transfer, prijs = :prijs WHERE id = :id";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $_POST['id']);
    $stmt->bindParam(':naam', $_POST['naam']);
    $stmt->bindParam(':datum', $_POST['datum']);
    $stmt->bindParam(':van_waar', $_POST['van_waar']);
    $stmt->bindParam(':status', $_POST['status']);
    $stmt->bindParam(':transfer', $_POST['transfer']);
    $stmt->bindParam(':prijs', $_POST['prijs']);
    $stmt->execute();

    echo "<p>Reis bijgewerkt!</p>";
}

$reisjes = $conn->query("SELECT * FROM reisjes")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Reisjes Bewerken</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .reisje { border: 1px solid #ccc; padding: 10px; margin-bottom: 10px; }
        input, textarea { width: 100%; margin-bottom: 10px; }
        input[type=submit] { width: auto; padding: 5px 10px; }
    </style>
</head>
<body>

<h1>Bewerk je reisjes</h1>

<?php foreach ($reisjes as $item): ?>
    <div class="reisje">
        <form method="POST">
            <input type="hidden" name="id" value="<?= $item['id'] ?>">

            <label>Naam:</label>
            <input type="text" name="naam" value="<?= $item['naam'] ?>" required>

            <label>Datum:</label>
            <input type="date" name="datum" value="<?= $item['wanneer'] ?>" required>

            <label>Van waar:</label>
            <input type="text" name="van_waar" value="<?= $item['van waar'] ?>" required>

            <label>Status:</label>
            <input type="text" name="status" value="<?= $item['status'] ?>" required>

            <label>Transfer:</label>
            <input type="text" name="transfer" value="<?= $item['transfer'] ?>" required>

            <label>Prijs (€):</label>
            <input type="number" step="0.01" name="prijs" value="<?= $item['prijs'] ?>" required>

            <input type="submit" value="Opslaan">
        </form>
    </div>
<?php endforeach; ?>

</body>
</html>
