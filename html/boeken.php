<?php
session_start();
$servername = "mysql_db";
$username = "root";
$password = "rootpassword";
// print_r($_SESSION);
try {
    $conn = new PDO("mysql:host=$servername;dbname=reisbureau", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}


if (isset($_POST['add'])) {
    $sql = "INSERT INTO boekingen (gebruikerID, reisjesID, totaalprijs) 
            VALUES (:gebruikerID, :reisjesID, :totaalprijs)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":gebruikerID", $_SESSION['user_id']);
    $stmt->bindParam(":reisjesID", $_SESSION['reis_id']);

    // Fetch reis info again to get the prijs (or move it above)
    $sqlPrijs = "SELECT prijs FROM reisjes WHERE id = :id";
    $stmtPrijs = $conn->prepare($sqlPrijs);
    $stmtPrijs->bindParam(':id', $_SESSION['reis_id']);
    $stmtPrijs->execute();
    $prijsResult = $stmtPrijs->fetch(PDO::FETCH_ASSOC);
    $stmt->bindParam(":totaalprijs", $prijsResult['prijs']);
    try {
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Insert failed: " . $e->getMessage();
        exit;
    }
    // Optional: redirect to avoid resubmission, change to personal info later
    header("Location: reizen.php?success=1");
    exit;
}
?>
<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css" />
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
    <?php
    $sql = "SELECT * FROM `reisjes` WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $_SESSION['reis_id']);
    $stmt->execute();
    $reisjes = $stmt->fetch();
    echo "<div class='reizen-main-background'>
        <p>" . $reisjes["naam"] . "</p>
        <div class='set-flex'>
            <div class='reizen-main-leftbox'>
                <div class='reizen-main-imgbox'>
                    <img class='reizen-img-vacations-left' src='assets/img/A87EFB075399E8DD614D3408B4C39369.jpg' alt='foto van de vacantie'>
                    <img class='reizen-img-vacations-right' src='assets/img/82DA0FCBBFB77554266673C9448F8FB3.jpg' alt='foto van de vacantie'>
                </div>
                <p>Aantal boekingen?</p>
            </div>
            <div class='reizen-main-rightbox'>
                <P class='reizen-infobar-top'>" . $reisjes["waneer"] . "</P>
                <p class='reizen-infobar'>" . $reisjes["van waar"] . "</p>
                <P class='reizen-infobar'>" . $reisjes["status"] . "</P>
                <P class='reizen-infobar'>" . $reisjes["transfer"] . "</P>
                <P class='reizen-infobar'>" . $reisjes["prijs"] . "</P>
            </div>
        </div>
    </div>";

    ?>
    <form action="boeken.php" method="post">
        <input type="submit" name="add" value="boeken">
    </form>
</html>

