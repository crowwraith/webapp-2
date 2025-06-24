<?php
session_start();
// Verbinding maken met de database
$servername = "mysql_db";
$username = "root";
$password = "rootpassword";
$dbname = "reisbureau";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Verbinding mislukt: " . $e->getMessage());
}

// Verwijder een reis als er een formulier is verstuurd met een ID
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['verwijder_id'])) {
    $id = $_POST['verwijder_id'];

    $stmt = $conn->prepare("DELETE FROM reisjes WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT); // Bind het ID als integer

    if ($stmt->execute()) {
        $melding = "✅ Reis met ID $id is verwijderd.";
    } else {
        $melding = "❌ Verwijderen mislukt.";
    }
}

$stmt = $conn->prepare("SELECT * FROM reisjes");
$stmt->execute();
$reizen = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Alle Reizen</title>
</head>
<body>
<header class="mobile-header">
    <a href="index.php" class="logo">Logo</a>
    <nav class="nav-buttons">
        <a href="admin.php">Over ons</a>
        <a href="ons.php">Over ons</a>
        <a href="reizen.php">reizen</a>
        <a href="contact.php">Service & Contact</a>
        <?php if (isset($_SESSION['username'])): ?>
            <a href="mijninfo.php">Mijn account</a>
        <?php endif; ?>

        <?php if (isset($_SESSION['username'])): ?>
            <a href="logout.php">Uitloggen (<?= $_SESSION['username']; ?>)</a>
        <?php else: ?>
            <a href="login.php">Login</a>
        <?php endif; ?>
    </nav>
</header>
<h1>Reizen Overzicht</h1>

<!-- Toon de melding als er één is (bijvoorbeeld: "reis verwijderd") -->
<?php if (isset($melding)): ?>
    <p><strong><?= $melding ?></strong></p>
<?php endif; ?>

<!-- Tabel met alle reizen -->
<table border="1" cellpadding="8">
    <thead>
    <tr>
        <th>ID</th>
        <th>Naam</th>
        <th>Wanneer</th>
        <th>Van waar</th>
        <th>Prijs</th>
        <th>Actie</th>
    </tr>
    </thead>
    <tbody>
    <!-- Loop door alle reizen heen -->
    <?php foreach ($reizen as $reis): ?>
        <tr>
            <td><?= $reis['id'] ?></td>
            <td><?= $reis['naam'] ?></td>
            <td><?= $reis['waneer'] ?></td>
            <td><?= $reis['van waar'] ?></td>
            <td>€ <?= number_format($reis['prijs'], 2, ',', '.') ?></td>
            <td>
                <!-- Verwijderformulier -->
                <form method="post" onsubmit="return confirm('Weet je zeker dat je deze reis wilt verwijderen?');">
                    <!-- Verborgen veld met het ID van de reis -->
                    <input type="hidden" name="verwijder_id" value="<?= $reis['id'] ?>">
                    <!-- Verwijderknop -->
                    <input type="submit" value="Verwijder">
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<!-- Terugknop naar admin-pagina -->
<br>
<a href="admin.php"><button>⬅️ Terug naar Admin</button></a>
</body>
</html>
