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
<main>
// 5 delen
</main>
<footer>
weiziging wlnfln
</footer>
</body>
</html>
