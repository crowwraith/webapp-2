<?php
session_start();
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

<?php
if (isset($_POST['zoekveld'])) {
    $sql = "SELECT * FROM `reisjes` WHERE naam LIKE :text";
    $stmt = $conn->prepare($sql);
    $zoekterm = "%" . $_POST['text'] . "%";
    $stmt->bindParam(":text", $zoekterm);
    $stmt->execute();
} else {
    $sql = "SELECT * FROM `reisjes`";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
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
    <title>Document</title>
</head>
<body>
<header>
    <a href="index.php" class="logo">Logo</a>
    <nav class="nav-buttons">
        <a href="ons.php">Over ons</a>
        <a href="reizen.php">reizen</a>
        <a href="contact.php">Service & Contact</a>
        <a href="login.php">Login</a>
    </nav>
</header>
<main>

</main>
<footer>
</footer>
</body>
</html>

