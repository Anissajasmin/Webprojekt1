<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hauptseite</title>
    <link rel="stylesheet" type="text/css" href="hauptseite.css">
</head>
<?php
session_start();
include_once "logincheck.php";
if (!isset($_SESSION['login-id'])) {
    echo "Bitte logge dich ein oder registriere dich zuerst. <a href=\"Startseite.php\">Zur Startseite</a>";
}else{
?>
<body>

<div id="hauptseite">


    <div id="header">
        <h1>TOUCH</h1>

        <ul id="navigation">

            <li class="listitem"><a href="#">Mein Feed</a></li>
            <li class="listitem"><a href="#">Mein Profil</a>
                <ul>
                    <li><a href="#"> Meine Daten</a></li>
                    <li><a href="#"> Meine Beiträge</a></li>
                    <li><a href="#"> Einstellungen</a></li>
                </ul>
            </li>
            <li class="listitem"><a href="#">Meine Freunde</a></li>

        </ul>


        <label id="suche1" for="suche">Search</label>
        <input type="search" id="suche" placeholder="Profile, ...">

    </div>

    <div id="main">

        <div id="recommondation">
            <h2 class="ueberschriftenmain"> Recommondations
            </h2>
        </div>

        <div id="background">

            <a style="text-decoration:none;" href="">
                <div id="buttonfriends">Friends</div>
            </a>



            <a style="text-decoration: none;" href="">
                <div id="buttonstudents">Students</div>
            </a>





            <form id= postbox2 action="login.php" method="post">
                     <textarea id="text" name="text" placeholder="Post something" cols="40" rows="4">
                        Hallo
                      </textarea>
                <br>
                <input type="submit">
            </form>



        </div>



        <div id="profile">
            <h2 class="ueberschriftenmain"> Profile
            </h2>
        </div>

    </div>



</div>
<?php
}
?>



</body>
</html>