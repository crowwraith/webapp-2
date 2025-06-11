<?php
$servername = "mysql_db";
$username = "root";
$password = "rootpassword";

try {
    $conn = new PDO("mysql:host=$servername;dbname=reisbureau", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// Recensie opslaan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recensie_submit'])) {
    $reis_id = $_POST['reis_id'];
    $naam = $_POST['naam'] ?? 'Anoniem';
    $recensie = $_POST['recensie'];

    if (!empty($recensie)) {
        $sqlInsert = "INSERT INTO recensies (reis_id, naam, recensie) VALUES (:reis_id, :naam, :recensie)";
        $stmtInsert = $conn->prepare($sqlInsert);
        $stmtInsert->execute([
            ':reis_id' => $reis_id,
            ':naam' => htmlspecialchars($naam),
            ':recensie' => htmlspecialchars($recensie)
        ]);
        echo "<p class='success'>Recensie succesvol toegevoegd!</p>";
    } else {
        echo "<p class='error'>Recensie mag niet leeg zijn.</p>";
    }
}

// Reizen ophalen (zoals jouw code)
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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="css/style.css" />
    <title>Reizen</title>
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

<main class="main-reizen">
    <div class="reizen-left-side">
        <form class="searchbox" name="searchbar" action="reizen.php" method="post">
            <input class="search" type="text" name="text" placeholder="zoek hier" />
            <div>
                <button class="search-button" type="submit" name="zoekveld">zoekknop</button>
            </div>
        </form>
    </div>

    <div class="reizen-right-side">
        <div class="reizen-salesboard">
            <img />
            <div class="reizen-sales">vacanties tot 499</div>
            <div class="reizen-sales">vacanties tot 699</div>
            <div class="reizen-sales">vacanties tot 999</div>
        </div>

        <?php while ($reisjes = $stmt->fetch(PDO::FETCH_ASSOC)) : ?>
            <div class="reizen-main-background">
                <h2><?= htmlspecialchars($reisjes["naam"]) ?></h2>
                <div class="set-flex">
                    <div class="reizen-main-leftbox">
                        <div class="reizen-main-imgbox">
                            <img class="reizen-img-vacations-left" src="assets/img/A87EFB075399E8DD614D3408B4C39369.jpg" alt="foto van de vacantie" />
                            <img class="reizen-img-vacations-right" src="assets/img/82DA0FCBBFB77554266673C9448F8FB3.jpg" alt="foto van de vacantie" />
                        </div>
                        <p>Aantal boekingen?</p>
                    </div>
                    <div class="reizen-main-rightbox">
                        <p class="reizen-infobar-top"><?= htmlspecialchars($reisjes["waneer"]) ?></p>
                        <p class="reizen-infobar"><?= htmlspecialchars($reisjes["van waar"]) ?></p>
                        <p class="reizen-infobar"><?= htmlspecialchars($reisjes["status"]) ?></p>
                        <p class="reizen-infobar"><?= htmlspecialchars($reisjes["transfer"]) ?></p>
                        <p class="reizen-infobar"><?= htmlspecialchars($reisjes["prijs"]) ?></p>
                        <a class="reizen-infobar-bottom" href="reizen.php">boeken</a>
                    </div>
                </div>

                <!-- Recensies ophalen -->
                <div class="recensies-lijst">
                    <h3>Recensies</h3>
                    <?php
                    $reis_id = $reisjes['id'];
                    $sqlRec = "SELECT * FROM recensies WHERE reis_id = :reis_id ORDER BY datum DESC";
                    $stmtRec = $conn->prepare($sqlRec);
                    $stmtRec->execute([':reis_id' => $reis_id]);
                    $recensies = $stmtRec->fetchAll(PDO::FETCH_ASSOC);
                    if ($recensies) {
                        foreach ($recensies as $recensie) {
                            echo "<div class='recensie'>
                            <strong>" . htmlspecialchars($recensie['naam']) . "</strong> 
                            <em>(" . date('d-m-Y H:i', strtotime($recensie['datum'])) . ")</em>
                            <p>" . nl2br(htmlspecialchars($recensie['recensie'])) . "</p>
                          </div>";
                        }
                    } else {
                        echo "<p>Er zijn nog geen recensies voor deze reis.</p>";
                    }
                    ?>
                </div>

                <!-- Recensie formulier -->
                <div class="recensie-formulier">
                    <h3>Plaats een recensie</h3>
                    <form action="reizen.php" method="post">
                        <input type="hidden" name="reis_id" value="<?= $reis_id ?>" />
                        <label for="naam-<?= $reis_id ?>">Naam:</label><br />
                        <input type="text" id="naam-<?= $reis_id ?>" name="naam" placeholder="Je naam (optioneel)" /><br />
                        <label for="recensie-<?= $reis_id ?>">Recensie:</label><br />
                        <textarea id="recensie-<?= $reis_id ?>" name="recensie" rows="4" required></textarea><br />
                        <button type="submit" name="recensie_submit">Verstuur recensie</button>
                    </form>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</main>

<footer></footer>
</body>
</html>
