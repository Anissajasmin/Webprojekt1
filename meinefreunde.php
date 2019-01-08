<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Meine Freund</title>
    <link rel="stylesheet" type="text/css" href="meinefreunde.css">
    <link rel="stylesheet" type="text/css" href="profilseite.css">
    <meta name = "viewport" content="width-device-width, initial-scale=1.0, maximum-scale=1.0, user scalelable=no">
</head>
<?php
include "includedesign.php";


session_start();
include_once "logincheck.php";
if (!isset($_SESSION['login-id'])) {
    echo "Bitte logge dich ein oder registriere dich zuerst. <a href=\"Startseite.php\">Zur Startseite</a>";
}else{
include ("datenbankpasswort.php");
include ("follow.php")
?>
<body>
<div id="main">

    <div id="recommendation">
        <h2 class="ueberschriftenmain"> Recommendations
        </h2>
    </div>



    <div id="background">
        <p id="meinefreunde"> Meine Freunde</p>

    </div>



    <div id="profile">
        <h2 class="ueberschriftenmain"> Profile
        </h2>

        <div id="tabellename">
            <?php
            echo $title['benutzername'];
            ?>
        </div>

        <div id="tabelleemail">
            <?php
            echo $title['hdm_mail'];
            ?>

        </div>

    </div>
















</body>
</html>

<?php
}
?>


