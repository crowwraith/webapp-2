<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}
$servername = "mysql_db";
$username = "root";
$password = "rootpassword";

try {
    $conn = new PDO("mysql:host=$servername;dbname=reisbureau", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - Reisbureau</title>
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>
<div class="admin-header">
    <h1>Welkom bij het Admin Panel</h1>
    <p>Beheer hier de reizen van het reisbureau.</p>
</div>
<div class="button-group">
    <a href="add.php"><button class="add-item-btn">Voeg Nieuwe Reis Toe</button></a>
    <a href="index.php"><button class="logout-btn">Home</button></a>
</div>
<div class="menu-section">
    <h2 class="menu-title">Geboekte reizen</h2>
    <div>
        <a href="bewerken.php?id=1"><button>Bewerken</button></a>
        <a href="delete.php?id=1"><button>Verwijderen</button></a>
    </div>
</div>
</body>
</html>
