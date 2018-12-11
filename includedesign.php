<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hauptseite</title>
    <link rel="stylesheet" type="text/css" href="includedesign.css">

<?php
session_start();
include_once "logincheck.php";
if (!isset($_SESSION['login-id'])) {
    echo "Bitte logge dich ein oder registriere dich zuerst. <a href=\"Startseite.php\">Zur Startseite</a>";
}else {
    include("datenbankpasswort.php");
}
?>


</head>

<body>

<div id="hauptseite">



        <div id = "searcharea" class ="header"><input placeholder= "Search here..." type="text" id="searchbox"/></div>
        <a style="text-decoration:none;" href="">
            <div id="notificationneu"><img src="notificationneu.png"/><div>
        </a>


        <a style="text-decoration:none;" href="">
            <div id="messageneu"><img src="messageneu.png"/><div>
        </a>


        <a style="text-decoration:none;" href="">
            <div id="settingneu"><img src="settingneu.png"/><div>
        </a>


    <div id="header">
        <h1>TOUCH</h1>
        <div id="logoutbutton"> <a href="logout.php">Log Out</a></div>
        <ul id="navigation">

            <li class="listitem"><a href="hauptseite.php">Mein Feed</a></li>
            <li class="listitem"><a href="profilseite.php">Mein Profil</a>
                <ul>
                    <li><a href="#"> Meine Daten</a></li>
                    <li><a href="#"> Meine Beiträge</a></li>
                    <li><a href="#"> Einstellungen</a></li>
                </ul>
            </li>
            <li class="listitem"><a href="#">Meine Freunde</a></li>

        </ul>


    </div>




</div>

</body>
</html>

