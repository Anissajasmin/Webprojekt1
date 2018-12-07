<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hauptseite</title>
    <link rel="stylesheet" type="text/css" href="hauptseite.css">

    <?php
    session_start();
    include_once "logincheck.php";
    if (!isset($_SESSION['login-id'])) {
        echo "Bitte logge dich ein oder registriere dich zuerst. <a href=\"Startseite.php\">Zur Startseite</a>";
    }else{
    include("datenbankpasswort.php");

    $textbox = array('posts');
    $posts = $_POST['posts'];
    $user_id = $_SESSION["login-id"];

    $fehlerfelder = array();

    if (isset($_POST['text'])) {
        $error = false;

        foreach ($textbox as $feld) {
            if (empty($_POST[$feld])) {
                $error = true;
                $fehlerfelder[$feld] = true;
            }
        }
    }
    //Einfügen des Textes, Fehlerausgabe wenn Textfeld leer abgeschickt wird

    if ($error === false) {

        $statement = $pdo->prepare("INSERT INTO beitrag (posts, user_id) VALUES ('$posts', '$user_id')");
        $result = $statement->execute();


        if ($result) {
            echo 'Danke für deinen Beitrag!';

        } else {

            if ($error === true)
                echo '<div id="meldung"> <br><br>Etwas ist schief gelaufen.<br> </div>';
        }
    }
    ?>

</head>


<body>

<div id="hauptseite">


    <div id="header">
        <h1>TOUCH</h1>

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

            <hr class="strich">

            <p id=neuerbeitrag> Neuer Beitrag</p>
            <br>

            <form  id= postbox2 action="hauptseite.php" method="post">
                <input type="hidden" name="text" value="1">
                <p id="text1"> Schreibe einen Beitrag (max. 1000 Zeichen):</p>
                <p><textarea id="post" name="posts" rows="5" cols="80" value="" ></textarea></p>
                <p><input id="button2" type="submit" name="textgesendet" value="Senden">
                    <input id="button3" type="reset" value="Abbruch"></p>
            </form>



            <form enctype="multipart/form-data"
                  name = "uploadformular" action="hauptseite.php" method="post">
                <input type="hidden" name="picture" value="1">
                <p id="text2"> Auswahl und Absenden des Bildes:</p>
                <p><input  id=dateiauswahl name="upfile" type="file"></p>
                <p><input id="button4" type="submit" name="bildgesendet" value="Hochladen">
                    <input id="button5" type="reset" value="Abbruch"></p>
            </form>

            <br>
            <hr class="strich">

            <div id="tabelleposts">
                <table class="tabelle1">
                    <tr>
                        <th>Benutzername</th>
                        <th>Text</th>
                    </tr>



                    <?php
                    //Chronik - wo die geposteten Beiträge auftauchen

                    $stmt = $pdo->prepare("SELECT * FROM vlj_beitraglogin ORDER BY zeitstempel DESC ");

                    $result = $stmt->execute();
                    while ($row = $stmt->fetch()) {
                        echo "<tr>";
                        echo "<td>" . $row["benutzername"] . "</td>";
                        echo "<td>" . $row["posts"] . "</td>";
                        echo "</tr>";
                    }
                    ?>

                </table>
            </div>



        </div>



        <div id="profile">
            <h2 class="ueberschriftenmain"> Profile
            </h2>
        </div>

    </div>



</div>

</body>
</html>


<br>
<br>
<div> Hier kannst du dich <a href="logout.php">ausloggen</a></div>

<?php
}
?>