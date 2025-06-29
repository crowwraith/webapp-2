<?php
session_start();
$servername = "mysql_db";
$username = "root";
$password = "rootpassword";

$reis_id = $_GET['id'];
$gebruikerID = $_GET['gebruikerID'];
$naam = $_SESSION['username'];

try {
    $conn = new PDO("mysql:host=$servername;dbname=reisbureau", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
if (isset($_POST['submit'])) {
    $recensie = $_POST['recensie'] ?? '';
    $datum = date('Y-m-d');

    if (trim($recensie) === '') {
        echo "Voer een geldige recensie in.";
    } else {
        $sql = "INSERT INTO recensies (reis_id, naam, recensie, datum) 
                VALUES (:reis_id, :naam, :recensie, :datum)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':reis_id', $reis_id);
        $stmt->bindParam(':naam', $naam);
        $stmt->bindParam(':recensie', $recensie);
        $stmt->bindParam(':datum', $datum);
        $stmt->execute();

        echo "Bedankt voor je recensie!";
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css"/>
    <title>Plaats een recensie</title>
</head>
<header class="mobile-header">
    <a href="index.php" class="logo">Logo</a>
    <nav class="nav-buttons">
        <a href="ons.php">Over ons</a>
        <a href="reizen.php">reizen</a>
        <a href="contact.php">Service & Contact</a>
        <?php if (isset($_SESSION['username'])): ?>
            <a href="mijninfo.php">Mijn account</a>
        <?php endif; ?>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <a href="admin.php">Admin Panel</a>
        <?php endif; ?>
        <?php if (isset($_SESSION['username'])): ?>
            <a href="logout.php">Uitloggen (<?= $_SESSION['username']; ?>)</a>
        <?php else: ?>
            <a href="login.php">Login</a>
        <?php endif; ?>

    </nav>
</header>
<body>
<h2 >Laat een recensie achter</h2>
<form method="POST" action="">
    <label  for="recensie">Jouw recensie:</label><br>
    <textarea class="textarea-recensies" name="recensie" id="recensie" rows="6" cols="50" required></textarea><br><br>
    <button type="submit" name="submit">Verstuur Recensie</button>
</form>
</body>
</html>
