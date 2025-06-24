<?php
$loginIncorrect = false;
session_start();
if (isset($_GET['reis_id'])) {
    $_SESSION['reis_id'] = $_GET['reis_id'];

    // You can now use $_SESSION['reis_id'] elsewhere on the page
}
if (isset($_SESSION['username']) && $_SESSION['username'] != null) {
     header("Location: boeken.php"); // doorverwijzing naar boeking in verband met aanmaken reis_id doorgeven.
    exit;
    // gaat fout als je session uitprint. mogelijke crash als er geen sessie is
}
else{
    header("Location: login.php");
}

?>

