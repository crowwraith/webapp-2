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
    <link rel="stylesheet" href="css/style.css"/>
</head>
<body>
<header class="mobile-header">
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
    <div class="admin-header">
        <h1>Welkom bij het Admin Panel</h1>
        <p>Beheer hier de reizen van het reisbureau.</p>
    </div>
    <div class="button-group">
        <a href="add.php"><button class="add-item-btn">Voeg Nieuwe Reis Toe</button></a>
        <a href="index.php"><button class="logout-btn">Home</button></a>
    </div>
    <div class="menu-section">
        <h2 class="menu-title">Beschikbare reizen</h2>
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

        // alle "kaartjes" ophalen vanuit database
        while ($reisjes = $stmt->fetch()) {
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
                         <div>
                            <a href='bewerken.php?id=" . $reisjes["id"] . "'><button>Bewerken</button></a>
                            <a href='delete.php?id=" . $reisjes["id"] . "'><button>Verwijderen</button></a>
                         </div>
                  </div>";
        }
        ?>
    <div class="menu-section">
        <h2 class="menu-title">Geboekte reizen</h2>
        <?php
        if (isset($_POST['zoekveld'])) {
            $sql = "SELECT boekingen.*, reisjes.naam AS reisNaam, reisjes.status 
            FROM boekingen 
            JOIN reisjes ON boekingen.reisjesID = reisjes.id 
            WHERE gebruiker LIKE :text";
            $stmt = $conn->prepare($sql);
            $zoekterm = "%" . $_POST['text'] . "%";
            $stmt->bindParam(":text", $zoekterm);
            $stmt->execute();
        } else {
            $sql = "SELECT boekingen.*, reisjes.naam AS reisNaam, reisjes.status 
            FROM boekingen 
            JOIN reisjes ON boekingen.reisjesID = reisjes.id";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
        }

        // alle "kaartjes" ophalen vanuit database

while ($boekingen = $stmt->fetch()) {
    echo "<div class='reizen-main-background'>
                      <p>" . $boekingen["id"] . "</p>
                         <div class='set-flex'>
                             <div class='reizen-main-leftbox'>
                                 <div class='reizen-main-imgbox'>
                                     <img class='reizen-img-vacations-left' src='assets/img/A87EFB075399E8DD614D3408B4C39369.jpg' alt='foto van de vacantie'>
                                     <img class='reizen-img-vacations-right' src='assets/img/82DA0FCBBFB77554266673C9448F8FB3.jpg' alt='foto van de vacantie'>
                                 </div>
                             </div>
                             <div class='reizen-main-rightbox'>
                                 <P class='reizen-infobar'>" . $boekingen["gebruikerID"] . "</P>
                                 <P class='reizen-infobar'>" . $boekingen["reisNaam"] . "</P>
                                 <P class='reizen-infobar-bottom'>" . $boekingen["totaalprijs"] . "</P>
                             </div>           
                         </div>
                         <div>
                            <a href='bewerken.php?id=" . $boekingen["id"] . "'><button>Bewerken</button></a>
                            <a href='delete.php?id=" . $boekingen["id"] . "'><button>Verwijderen</button></a>
                         </div>
                  </div>";
} ?>
    </div>
</body>
</html>
