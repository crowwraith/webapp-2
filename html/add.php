<?php
// Database connectie
$servername = "mysql_db";
$username = "root";
$password = "rootpassword";

try {
    $conn = new PDO("mysql:host=$servername;dbname=reisbureau", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $naam = $_POST['naam'] ?? '';
    $waneer = $_POST['waneer'] ?? '';
    $van_waar = $_POST['van_waar'] ?? '';
    $status = $_POST['status'] ?? '';
    $transfer = $_POST['transfer'] ?? '';
    $prijs = $_POST['prijs'] ?? '';

    if ($naam && $waneer && $van_waar && $status && $transfer && $prijs) {
        $sql = "INSERT INTO reisjes (naam, waneer, `van waar`, status, transfer, prijs)
                VALUES (:naam, :waneer, :van_waar, :status, :transfer, :prijs)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':naam' => $naam,
            ':waneer' => $waneer,
            ':van_waar' => $van_waar,
            ':status' => $status,
            ':transfer' => $transfer,
            ':prijs' => $prijs
        ]);
        $message = "Reis succesvol toegevoegd!";
    } else {
        $message = "Vul alle velden in.";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Voeg Nieuwe Reis Toe</title>
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>
<main>
    <h1>Voeg een nieuwe reis toe</h1>

    <?php if ($message): ?>
        <p><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form method="POST" action="add.php">
        <label for="naam">Naam reis:</label><br>
        <input type="text" id="naam" name="naam" required><br>

        <label for="waneer">Wanneer (datum):</label><br>
        <input type="date" id="waneer" name="waneer" required><br>

        <label for="van_waar">Van waar:</label><br>
        <input type="text" id="van_waar" name="van_waar" required><br>

        <label for="status">Status:</label><br>
        <input type="text" id="status" name="status" required><br>

        <label for="transfer">Transfer:</label><br>
        <input type="text" id="transfer" name="transfer" required><br>

        <label for="prijs">Prijs (€):</label><br>
        <input type="number" id="prijs" name="prijs" step="0.01" required><br><br>

        <button type="submit">Toevoegen</button>
    </form>

    <a href="admin.php">Terug naar Admin</a>
</main>
</body>
</html>
