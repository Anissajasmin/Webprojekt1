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
        echo "Aktiviere zuerst deinen Account mittels der Email, die wir dir geschickt haben oder registriere dich zuerst. <a href=\"Startseite.php\">Zur Startseite</a>";
    }else{
    include("datenbankpasswort.php");


$my_id = $_SESSION['login-id'];
$user_id= $_GET['user_id'];

//Profildaten der unterschiedlichen Nutzer
$visit_user = $pdo ->prepare ("SELECT * FROM login WHERE login_id=$user_id");
$visit_user ->execute();
$title = $visit_user ->fetch();


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
        $statement->bindParam('posts', $posts);
        $statement->bindParam('user_id', $user_id);
        $result = $statement->execute();


        if ($result) {
            echo 'Danke für deinen Beitrag!';

        } else {

            if ($error === true)
                echo '<div id="meldung"> <br><br>Etwas ist schief gelaufen.<br> </div>';
        }
    }
    ?>

    <?php

    //Einfügen Bild

    $upload_ordner = 'bilder/'; //Das Upload-Verzeichnis

    $tmpname = $_FILES["upfile"] ["name"];
    $tmpname_teile = explode( ".", $tmpname);
    $endung = $tmpname_teile [count($tmpname_teile) - 1];

    //Überprüfung der Bildendung
    $erlaubte_endungen = array('png', 'jpg', 'jpeg', 'gif');
    if (isset($_POST['bildgesendet'])){
        if(!in_array($endung, $erlaubte_endungen)) {
            die("Es sind nur png, jpg, jpeg und gif-Dateien erlaubt.");
        } else {
            $bildname = "post_" . date("YmdHis") . $endung;

            //Pfad zum Upload
            $new_path = $upload_ordner.$bildname.'.'.$endung;

            //In DB einfügen

            $statement = $pdo->prepare("INSERT INTO beitrag (bildtext, user_id) VALUES ('$new_path', '$user_id')");
            $statement->bindParam('bildtext', $new_path);
            $statement->bindParam('user_id', $user_id);
            $result = $statement->execute();
        }
    }

    //Überprüfung der Dateigröße, nicht größer als 500 kB
    $max_size = 500*1024;
    if($_FILES['upfile']['size'] > $max_size) {
        die("Bitte keine Dateien größer 500kb hochladen.");
    }

    //Überprüfung, dass das Bild keine Fehler enthält
    if(isset($_POST["bildgesendet"])) {
        if (function_exists('exif_imagetype')) {
            $erlaubte_typen = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
            $geschuetzte_typen = exif_imagetype($_FILES['upfile']['tmp_name']);
            if (!in_array($geschuetzte_typen, $erlaubte_typen)) {
                die("Nur der Upload von Bilddateien ist gestattet");
            }
        }
    }

    //Alles okay, verschiebe Bild an neuen Pfad
    move_uploaded_file($_FILES['upfile']['tmp_name'], $new_path);
    //echo 'Bild erfolgreich hochgeladen: <a href="'.$new_path.'">'.$new_path.'</a>';
    ?>

</head>

<body>

<div id="hauptseite">

    <div id="header">
        <h1>TOUCH</h1>
        <div id="logoutbutton"> <a href="logout.php">Log Out</a></div>
        <ul id="navigation">

            <li class="listitem"><a href="hauptseite.php?user_id=<?php echo $user_id; ?>">Mein Feed</a></li>
            <li class="listitem"><a href="profilseite.php?user_id=<?php echo $user_id; ?>">Mein Profil</a>
                <ul>
                    <li><a href="#"> Meine Daten</a></li>
                    <li><a href="#"> Meine Beiträge</a></li>
                    <li class =“listitem"><a href="settings.php?user_id=<?php echo $user_id; ?>">Einstellungen</a></li>

                </ul>
            </li>
            <li class="listitem"><a href="#">Meine Freunde</a></li>

        </ul>

        <form action="" id = "searcharea" class ="header" method="post">
            <input placeholder= "Search here..." type="text" name="suche" id="searchbox"/>
            <input type="hidden" name="suchegesendet" value="1">
            <input id="" type="submit" value="Suchen">
        </form>
    </div>
        <?php
        //Suchfunktion

        if (isset($_POST["suche"])) {
        $allebenutzername = $_POST["suche"];

        $benutzersuche = $pdo->prepare("SELECT * FROM vlj_loginprofilbild WHERE benutzername = '$allebenutzername' AND aktiviert = 1");
        if ($benutzersuche->execute()) {

        while ($row = $benutzersuche->fetch()) {
        $userid = $row ['login_id'];
        ?>
        <h3>
            <a href="profilseite.php?user_id=<?php echo $userid ?>"><img src="<?php echo $row['profilbildtext'] ?>"></a>
            <a href="profilseite.php?user_id=<?php echo $userid ?>"><?php echo $row['benutzername'] ?></a>
        </h3>

        <?php
        }
    } else {
        echo "<div>No user found</div>";
    }
}
?>


    <div id="main">

        <div id="recommendation">
            <h2 class="ueberschriftenmain"> Recommendations
            </h2>
        </div>

        <div id="background">


            <a style="text-decoration: none;" href="hauptseite.php?user_id=<?php echo $user_id; ?>">
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

            <div>

                    <?php
                    //Chronik wo die geposteten Beiträge der Freunde angezeigt werden sollen
                    //Es wird zuerst geschaut, ob man jemandem folgt

    $checkfollow=$pdo->prepare("SELECT * FROM follow WHERE follow_id=$my_id");
    $checkfollow->execute();
    $nofollower=$checkfollow->rowCount();
        if(!$nofollower > 0) {
            //Wenn man niemandem folgt
            echo "<div id=\"tabelleposts\">";
            echo "Du hast noch keine Freunde. Folge erstmal einem Nutzer hier bei Touch!";
            echo "</div>";
        }
        else {
            //Wenn man jemandem folgt, werden die Posts von sich und die der User, denen man folgt, angezeigt
            while($row = $checkfollow->fetch()) {
                    $userid = $row['user_id'];
                    $show_posts = $pdo->prepare("SELECT * FROM vlj_beitraglogin WHERE user_id= $userid OR user_id= $my_id
                                                ORDER BY zeitstempel DESC");
                    $show_posts->execute();

                while ($row3 = $show_posts->fetch()) {

                    echo "<div id=\"tabelleposts\">";
                    echo "<span>";
                    echo $row3["benutzername"];
                    echo "</span>";
                    echo "<div id=\"poststext\">" . $row3['posts'] . "</div>";
                    echo "<img src='" . $row3['bildtext'] . "'height='200'>";
                    echo "</div>";
                }
            }
        }

       /** $show_myposts = $pdo->prepare("SELECT * FROM vlj_beitraglogin WHERE user_id = $my_id ORDER BY zeitstempel DESC");
        $show_myposts->execute();
        var_dump($show_myposts);
        while ($row2 = $show_myposts->fetch()) {

            echo "<div id=\"tabelleposts\">";
            echo "<span>";
            echo $row2["benutzername"];
            echo "</span>";
            echo "<div id=\"poststext\">" . $row2['posts'] . "</div>";
            echo "<img src='" . $row2['bildtext'] . "'height='200'>";
            echo "</div>";
        }

}
**/
                ?>

        </div>
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

    </div>

</div>

</body>
</html>

<br>
<br>

<?php
}
?>