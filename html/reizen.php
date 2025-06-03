<?php
$servername = "mysql_db_2";
$username = "root";
$password = "rootpassword";

try {
    $conn = new PDO("mysql:host=$servername;dbname=restaurant_1", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<header>
<div class="index-header-main">
    <div class="index-header-topbar">
        // TODO alleen vliegvakanties, rest optioneel aanbod
        <div><a href="index.php">vacanties</a></div>
        <div><a href="index.php">vliegtickets</a></div>
        <div><a href="index.php">cruises</a></div>
        <div><a href="index.php">meer reizen</a></div>
        <p>vind jou ideale vakantie</p>
    </div>
    <div class="index-header-searchbars">
        <div>
            <div> vakantietype  </div>
            <div> bestemming    </div>
            <div> wanneer       </div>
            <div> wie?          </div>
        </div>
        <div>
            <zoekvelden voor bovenstaande opties. zie databasebeheer>
        </div>
        <div>zoeken</div>
    </div>
</div>
</header>
<main class="main-reizen">
    <div class="reizen-left-side">
        <form class="searchbox" name="searchbar" action="reizen.php" method="post">
            <input class="search" type="text" name="text" placeholder="zoek hier">
            <div>
                <button class="search-button" type="submit" name="zoekveld">
                    <p>zoekknop</p>
                </button>
            </div>
        </form>
    </div>
    <?php
    ?>
    <div class="reizen-right-side">
        <div class="reizen-salesboard" >
            <img>
            <div class="reizen-sales">vacanties tot 499</div>
            <div class="reizen-sales">vacanties tot 699</div>
            <div class="reizen-sales">vacanties tot 999</div>
        </div>
        <!--style voor database "kaart" -->
        <div class="reizen-main-background">
            <p>naam van de vacantie</p>
            <div class="set-flex">
                <div class="reizen-main-leftbox">
                    <div class="reizen-main-imgbox">
                        <img class="reizen-img-vacations-left" src="assets/img/A87EFB075399E8DD614D3408B4C39369.jpg" alt="foto van de vacantie">
                        <img class="reizen-img-vacations-right" src="assets/img/82DA0FCBBFB77554266673C9448F8FB3.jpg" alt="foto van de vacantie">
                    </div>
                    <p>aantal boekingen?</p>
                </div>
                <div class="reizen-main-rightbox">
                    <P class="reizen-infobar-top">wanneer de reis is</P>
                    <p class="reizen-infobar">vanaf waar de reis is</p>
                    <P class="reizen-infobar">status/all inclusive. logies</P>
                    <P class="reizen-infobar">transfer y/n</P>
                    <!--style i.p.v prijs boeken op de "kaart" -->
                    <a class="reizen-infobar-bottom" href="reizen.php">boeken  </a>
                </div>
            </div>
        </div>
    </div>
</main>
<footer>

</footer>
</body>
</html>
