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
<main class="main-reizen">
    <div class="reizen-left-side">
        <form class="searchbox" name="searchbar" action="reizen.php" method="post">
            <input class="search" type="text" name="text" placeholder="zoek hier op land">
            <div>
                <button class="search-button" type="submit" name="zoekveld">zoekknop</button>
            </div>
        </form>
    </div>
        <!--style voor database "kaart" -->
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
                                <a class='reizen-infobar-bottom' href='login-boeken.php?reis_id=" . $reisjes['id'] . "'>boeken</a>
                             </div>           
                         </div>
                  </div>";
        }
        ?>
</main>
<footer>
</footer>
</body>
</html>
