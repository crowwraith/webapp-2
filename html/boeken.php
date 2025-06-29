<?php
session_start();
$servername = "mysql_db";
$username = "root";
$password = "rootpassword";
// print_r($_SESSION);
try {
    $conn = new PDO("mysql:host=$servername;dbname=reisbureau;charset=utf8;" , $username, $password);
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
    <title>Boek je reis</title>
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>

<header>
    <a href="index.php" class="logo">Logo</a>
    <nav class="nav-buttons">
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

    <div class='boeken-info'>
        <?php
        if (!empty($reisjes["info"])) {
         //   var_dump($reisjes);
            echo "<p class='reizen-infobar-top'>" . ($reisjes["info"]) . "</p>";
        } else {
            echo "<p class='reizen-infobar-bottom'>No extra info found</p>";
        }
        ?>
    </div>
    <form action="boeken.php" method="post">
        <input type="submit" name="add" value="boeken">
    </form>
    <?php

    $reis_id = isset($_SESSION['reis_id']) && is_numeric($_SESSION['reis_id']) ? (int)$_SESSION['reis_id'] : null;
    if (!$reis_id) {
        echo "<p>Ongeldige reis geselecteerd.</p>";
        exit;
    }

    $sqlRecensies = "SELECT naam, recensie, datum FROM recensies WHERE reis_id = :reis_id ORDER BY datum DESC";
    $stmtRecensies = $conn->prepare($sqlRecensies);
    $stmtRecensies->bindParam(':reis_id', $reis_id, PDO::PARAM_INT);
    $stmtRecensies->execute();
    $recensies = $stmtRecensies->fetchAll(PDO::FETCH_ASSOC);

    echo "<div class='reizen-main-background'>";
    echo "<h2 class='reizen-infobar-top'>Recensies</h2>";

    if ($recensies) {
        foreach ($recensies as $recensie) {
            echo "<div class='reizen-main-rightbox'>";
            echo "<p class='reizen-infobar'><strong>" . htmlspecialchars($recensie['naam']) . "</strong></p>";
            echo "<p class='reizen-infobar'>" . nl2br(htmlspecialchars($recensie['recensie'])) . "</p>";
            echo "<p class='reizen-infobar'>" . date("d-m-Y", strtotime($recensie['datum'])) . "</p>";
            echo "</div>";
        }
    } else {
        echo "<div class='reizen-main-rightbox'>";
        echo "<p class='reizen-infobar'>Er zijn nog geen recensies voor deze reis.</p>";
        echo "</div>";
    }

    echo "</div>";


    ?>
</main>
</body>
</html>

