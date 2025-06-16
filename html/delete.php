<?php
$servername = "mysql_db";
$username = "root";
$password = "rootpassword";

// Verbind met de database
try {
    $conn = new PDO("mysql:host=$servername;dbname=reisbureau", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Databaseverbinding mislukt: " . $e->getMessage());
}

// Verwijder reis als er een POST is
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $deleteId = $_POST['delete_id'];

    $sql = "DELETE FROM reisjes WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $deleteId, PDO::PARAM_INT);

    if ($stmt->execute()) {
        $melding = " Reis met ID $deleteId is verwijderd.";
    } else {
        $melding = " Fout bij het verwijderen van reis met ID $deleteId.";
    }
}

// Haal alle reizen op
$sql = "SELECT * FROM reisjes";
$stmt = $conn->prepare($sql);
$stmt->execute();
$reizen = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Reizen Verwijderen</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<main>
    <h1>Beheer Reizen – Verwijderen</h1>

    <?php if (isset($melding)): ?>
        <p style="color: green;"><?= htmlspecialchars($melding) ?></p>
    <?php endif; ?>

    <table border="1" cellpadding="8">
        <thead>
        <tr>
            <th>ID</th>
            <th>Naam</th>
            <th>Wanneer</th>
            <th>Van waar</th>
            <th>Status</th>
            <th>Transfer</th>
            <th>Prijs</th>
            <th>Actie</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($reizen as $reis): ?>
            <tr>
                <td><?= htmlspecialchars($reis['id']) ?></td>
                <td><?= htmlspecialchars($reis['naam']) ?></td>
                <td><?= htmlspecialchars($reis['waneer']) ?></td>
                <td><?= htmlspecialchars($reis['van waar']) ?></td>
                <td><?= htmlspecialchars($reis['status']) ?></td>
                <td><?= htmlspecialchars($reis['transfer']) ?></td>
                <td>€ <?= number_format($reis['prijs'], 2, ',', '.') ?></td>
                <td>
                    <form method="POST" action="delete.php" onsubmit="return confirm('Weet je zeker dat je deze reis wilt verwijderen?');">
                        <input type="hidden" name="delete_id" value="<?= $reis['id'] ?>">
                        <button type="submit">Verwijder</button>
                    </form>

                </td>
            </tr>
        <?php endforeach; ?>
        <a href="admin.php">
            <button type="button">⬅️ Terug naar Admin</button>
        </a>
        </tbody>
    </table>

</main>
</body>
</html>
