<?php
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="Style.css">
</head>
<body>
<header>

</header>

<main-reizen>
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
                        <img class="reizen-img-vacations-left" src="Img/A87EFB075399E8DD614D3408B4C39369.jpg" alt="foto van de vacantie">
                        <img class="reizen-img-vacations-right" src="Img/82DA0FCBBFB77554266673C9448F8FB3.jpg" alt="foto van de vacantie">
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
</main-reizen>


<footer>

</footer>
</body>
</html>
