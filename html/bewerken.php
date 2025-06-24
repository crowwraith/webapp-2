<?php
session_start();
$servername = "mysql_db";
$username = "root";
$password = "rootpassword";
$id = (int)$_GET['id'];
try {
    $conn = new PDO("mysql:host=$servername;dbname=reisbureau", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Verbinding mislukt: " . $e->getMessage();
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "UPDATE reisjes SET naam = :naam, waneer = :waneer, `van waar` = :van_waar, status = :status, transfer = :transfer, prijs = :prijs WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $_POST['id']);
    $stmt->bindParam(':naam', $_POST['naam']);
    $stmt->bindParam(':waneer', $_POST['waneer']);
    $stmt->bindParam(':van_waar', $_POST['van_waar']);
    $stmt->bindParam(':status', $_POST['status']);
    $stmt->bindParam(':transfer', $_POST['transfer']);
    $stmt->bindParam(':prijs', $_POST['prijs']);
    $stmt->execute();
    echo "<p>Reis bijgewerkt!</p>";
}

$sqlSelect = "SELECT * FROM reisjes WHERE id = :id";
$stmtSelect = $conn->prepare($sqlSelect);
$stmtSelect->bindParam(':id', $id, PDO::PARAM_INT);
$stmtSelect->execute();
$reis = $stmtSelect->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Bewerk je reizen</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .reis { border: 1px solid #ccc; padding: 10px; margin-bottom: 10px; }
        input[type=text], input[type=date], input[type=number] { width: 100%; margin-bottom: 5px; }
        input[type=submit] { padding: 5px 10px; }
    </style>
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
<h1>Bewerk hier je reizen</h1>

<?php if ($reis): ?>
<div class="reis">
    <form method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($reis['id']) ?>">

        <label>Naam:</label>
        <input type="text" name="naam" value="<?= htmlspecialchars($reis['naam']) ?>" required>

        <label>Wanneer:</label>
        <input type="date" name="waneer" value="<?= htmlspecialchars($reis['waneer']) ?>" required>

        <label>Van waar:</label>
        <input type="text" name="van_waar" value="<?= htmlspecialchars($reis['van waar']) ?>" required>

        <label>Status:</label>
        <input type="text" name="status" value="<?= htmlspecialchars($reis['status']) ?>" required>

        <label>Transfer:</label>
        <input type="text" name="transfer" value="<?= htmlspecialchars($reis['transfer']) ?>" required>

        <label>Prijs (€):</label>
        <input type="number" step="0.01" name="prijs" value="<?= htmlspecialchars($reis['prijs']) ?>" required>

        <input type="submit" value="Opslaan">
    </form>
</div>
<?php else: ?>
<p>Geen reis gevonden met deze ID.</p>
<?php endif; ?>


</body>
</html>
