<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hauptseite</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="bootstrap.min.js"></script>
    <script src="jquery-3.2.1.slim.min.js"></script>
    <script src="bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="hauptseite.css">

    <?php
    session_start();
    include_once "logincheck.php";
    if (!isset($_SESSION['login-id'])) {
        echo "Aktiviere zuerst deinen Account mittels der Email, die wir dir geschickt haben oder registriere dich zuerst. <a href=\"Startseite.php\">Zur Startseite</a>";
    }else{
    include("datenbankpasswort.php");

    $my_id = $_SESSION['login-id'];
    $user_id = $_GET['user_id'];

    //Profildaten der unterschiedlichen Nutzer
    $visit_user = $pdo->prepare("SELECT * FROM login WHERE login_id=$user_id");
    $visit_user->execute();
    $title = $visit_user->fetch();


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

        $statement = $pdo->prepare("INSERT INTO beitrag (posts, beitrag_user_id) VALUES ('$posts', '$user_id')");
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
    $tmpname_teile = explode(".", $tmpname);
    $endung = $tmpname_teile [count($tmpname_teile) - 1];

    //Überprüfung der Bildendung
    $erlaubte_endungen = array('png', 'jpg', 'jpeg', 'gif');
    if (isset($_POST['bildgesendet'])) {
        if (!in_array($endung, $erlaubte_endungen)) {
            die("Es sind nur png, jpg, jpeg und gif-Dateien erlaubt.");
        } else {
            $bildname = "post_" . date("YmdHis") . $endung;

            //Pfad zum Upload
            $new_path = $upload_ordner . $bildname . '.' . $endung;

            //In DB einfügen

            $statement = $pdo->prepare("INSERT INTO beitrag (bildtext, beitrag_user_id) VALUES ('$new_path', '$user_id')");
            $statement->bindParam('bildtext', $new_path);
            $statement->bindParam('user_id', $user_id);
            $result = $statement->execute();
        }
    }

    //Überprüfung der Dateigröße, nicht größer als 500 kB
    $max_size = 500 * 1024;
    if ($_FILES['upfile']['size'] > $max_size) {
        die("Bitte keine Dateien größer 500kb hochladen.");
    }

    //Überprüfung, dass das Bild keine Fehler enthält
    if (isset($_POST["bildgesendet"])) {
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

<nav class="navbar navbar-expand-lg navbar-light "style= "background-color: #7B0202; font-family: 'Helvetica Neue'; color: white;">
    <a class="navbar-brand "href="#">TOUCH</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="hauptseite.php?user_id=<?php echo $user_id; ?>"> Mein Feed <span class="sr-only">(current)</span></a>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Mein Profil
                </a>
                <div class="dropdown-menu bg-dunkel" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="settings.php">Einstellungen</a>
                    <a class="dropdown-item" href="#">Falls wir noch ne seite einfügen</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="meinefreunde.php?user_id=<?php echo $user_id; ?>">Meine Freunde</a>
            </li>

        </ul>
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Suche deine Freunde..">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Suchen</button>
        </form>
        <li class="nav-item">
            <a class="logoutbutton" href="logout.php">Logout</a>
        </li>
    </div>
</nav>



<div id="hauptseite">


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



</div>


<div id="main">
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div id="recommendation">
                    <h2 class="ueberschriftenmain"> Recommendations
                    </h2>
                </div>

            </div>
            <div class="col-sm-6">
                <div id="background">
                    <a style="text-decoration:none;" href="friends.php?user_id=<?php echo $user_id; ?>">
                        <div id="buttonfriends">Friends</div>
                    </a>


                    <hr class="strich">

                    <div id=neuerbeitrag> Neuer Beitrag</div>
                    <br>

                    <form id=postbox2 action="hauptseite.php" method="post">
                        <input type="hidden" name="text" value="1">
                        <p id="text1"> Schreibe einen Beitrag (max. 1000 Zeichen):</p>
                        <p><textarea id="post" name="posts" rows="5" cols="80" value=""></textarea></p>
                        <p><input id="buttonsenden" type="submit" name="textgesendet" value="Senden">
                            <input id="buttonabbruch" type="reset" value="Abbruch"></p>
                    </form>

                    <form enctype="multipart/form-data"
                          name="uploadformular" action="hauptseite.php" method="post">
                        <input type="hidden" name="picture" value="1">
                        <p id="text2"> Auswahl und Absenden des Bildes:</p>
                        <p><input id=dateiauswahl name="upfile" type="file"></p>
                        <p><input id="button4" type="submit" name="bildgesendet" value="Hochladen">
                            <input id="button5" type="reset" value="Abbruch"></p>
                    </form>

                    <br>
                    <hr class="strich">

                    <div>

                        <?php
                        //Chronik - wo die geposteten Beiträge auftauchen

                        $stmt = $pdo->prepare("SELECT * FROM vlj_beitraglogin WHERE posts IS NOT NULL OR bildtext IS NOT NULL ORDER BY zeitstempel DESC");

                        $result = $stmt->execute();
                        while ($row = $stmt->fetch()) {
                            echo "<div id=\"tabelleposts\">";
                            echo $row["benutzername"];
                            echo "<div id=\"poststext\">" . $row['posts'] . "</div>";
                            echo "<img src='" . $row['bildtext'] . "'height='150'>";
                            echo "</div>";
                        }
                        ?>

                    </div>
                </div>
            </div>


            <div class="col-sm-3">
                <div id="profile">
                    <h2 class="ueberschriftenmain"> Profile
                    </h2>
                    <div class="name"> Benutzername:
                        <?php
                        echo $title['benutzername'];
                        ?>
                    </div>

                    <div class= "adresseneu"> E-Mail Adresse:
                        <?php
                        echo $title['hdm_mail'];
                        ?>

                    </div>
                </div>
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