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
        JOIN reisjes ON boekingen.reisjesID = reisjes.id 
        WHERE gebruikerID LIKE :userID";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":userID",  $_SESSION['user_id']);
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

        <?php if (isset($_SESSION['username'])): ?>
            <a href="logout.php">Uitloggen (<?= $_SESSION['username']; ?>)</a>
        <?php else: ?>
            <a href="login.php">Login</a>
        <?php endif; ?>
    </nav>
</header>
<main>
    <?php
    $sql = "SELECT * FROM `gebruikers` WHERE id = :text";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":text", $_SESSION['user_id']);
    $stmt->execute();
    while ($gebruikers = $stmt->fetch()) {
        echo "<div class='userInfoMain'>
                <div>je klantnummer is: " . $gebruikers["id"] . "</div>
                <div>je gebruikersnaam is: " . $gebruikers["username"] . "</div>
                
                </div";
    }
    ?>
    <?php
    // boekingen die opgehaald zijn komen hier
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
        JOIN reisjes ON boekingen.reisjesID = reisjes.id 
        WHERE gebruikerID LIKE :userID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":userID",  $_SESSION['user_id']);
        $stmt->execute();
    }
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
                                 <P class='reizen-infobar'>" . $boekingen["totaalprijs"] . "</P>
                             </div>           
                         </div>
                          <div>
                            <a href='mijninfo-annuleren.php?id=" . $boekingen["id"] . "&gebruikerID=" . $boekingen["gebruikerID"] . "'>
                                <button>Annuleren</button>
                            </a>
                         </div>
                  </div>";
    }
    ?>

</main>
<footer>
</footer>
</body>
</html>

