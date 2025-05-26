<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - Reisbureau</title>
    <link rel="stylesheet" href="css/style.css"/>
</head>
<body>
<div class="admin-header">
    <h1>Welkom bij het Admin Panel</h1>
    <p>Beheer hier de reizen van het reisbureau.</p>
</div>

<div class="button-group">
    <a href="add.php"><button class="add-item-btn">Voeg Nieuwe Reis Toe</button></a>
    <a href="logout.php"><button class="logout-btn">Uitloggen</button></a>
</div>

<div class="menu-section">
    <h2 class="menu-title">Beschikbare Reizen</h2>

    <!-- Voorbeeld reizen -->
    <div>
        <h3>Stedentrip naar Parijs</h3>
        <p>€299,00</p>
        <p>3 dagen, inclusief hotel en ontbijt</p>
        <a href="bewerken.php?id=1"><button>Bewerken</button></a>
        <a href="delete.php?id=1"><button>Verwijderen</button></a>
    </div>
    <hr>

    <div>
        <h3>Zonvakantie in Malaga</h3>
        <p>€749,00</p>
        <p>7 dagen, inclusief vlucht en hotel</p>
        <a href="bewerken.php?id=2"><button>Bewerken</button></a>
        <a href="delete.php?id=2"><button>Verwijderen</button></a>
    </div>
    <hr>

    <div>
        <h3>Rondreis door Thailand</h3>
        <p>€1.499,00</p>
        <p>14 dagen, inclusief excursies</p>
        <a href="bewerken.php?id=3"><button>Bewerken</button></a>
        <a href="delete.php?id=3"><button>Verwijderen</button></a>
    </div>
    <hr>
</div>
</body>
</html>
