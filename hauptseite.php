<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mein Feed</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="touch.css">

    <?php
    session_start();
    include_once "logincheck.php";
    if (!isset($_SESSION['login-id'])) {
        echo "Aktiviere zuerst deinen Account mittels der Email, die wir dir geschickt haben oder registriere dich zuerst. <a href=\"Startseite.php\">Zur Startseite</a>";
    }else{
    include("datenbankpasswort.php");
    include("header.php");
    $my_id = $_SESSION['login-id'];
    $user_id = $_GET['user_id'];
    //Profildaten der unterschiedlichen Nutzer
    $visit_user = $pdo->prepare("SELECT * FROM login WHERE login_id=$user_id");
    $visit_user->execute();
    $title = $visit_user->fetch();
    ?>

</head>
<body>

<div id="hauptseite">
    <div id="main">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div id="recommendation">
                        <h2 class="ueberschriftenmain"> Recommendations
                        </h2>
                        <br>
                        <br>
                        <?php
                        //Nutzer, denen man noch nicht folgt werden hier angezeigt
                        //Wird dem Benutzer bereits gefolgt?
                        $checkfollow = $pdo->prepare("SELECT * FROM follow WHERE follow_id='" . $my_id . "'");
                        $checkfollow->execute();
                        $notfollowing = $checkfollow->rowCount();
                        if (!$notfollowing > 0) {
                            $showallusers = $pdo->prepare ("SELECT * FROM profilbildlogin WHERE NOT login_id = $my_id");
                            $showallusers->execute();
                            while ($row1 = $showallusers->fetch()){
                                $allusers = $row1['login_id'];
                                echo "<div id=\"tabelleposts\">";
                                echo "<span>";
                                ?>
                                <div id="kasten">
                                    <a href="profilseite.php?user_id=<?php echo $allusers ?>"><img id="recommendationprofilbild" src="<?php echo $row1['profilbildtext'] ?>"></a>
                                    <a style="text-decoration:none;" href="profilseite.php?user_id=<?php echo $allusers ?>"><div id="kastentext"><?php echo $row1['benutzername'] ?></div></a>
                                </div>
                                <?php
                                echo "</span>";
                                echo "</div>";
                            }
                        } else{
                            $row = $checkfollow->fetch();
                            $userid = $row['user_id'];
                            $my_id = $row ['follow_id'];
                            //Wenn man jemandem nicht folgt, werden die Namen der Personen, denen man nicht folgt, in dieser Liste angezeigt
                            $show_users = $pdo->prepare("SELECT * FROM profilbildlogin WHERE NOT login_id = $my_id AND NOT login_id = $userid LIMIT 3");
                            $show_users->execute();
                            while($row3 = $show_users->fetch()) {
                                $users = $row3['login_id'];
                                echo "<div id=\"tabelleposts\">";
                                echo "<span>";
                                ?>
                                <div id="kasten">
                                    <a href="profilseite.php?user_id=<?php echo $users ?>"><img id="recommendationprofilbild" src="<?php echo $row3['profilbildtext'] ?>"></a>
                                    <a style="text-decoration:none;" href="profilseite.php?user_id=<?php echo $users ?>"><div id="kastentext"><?php echo $row3['benutzername'] ?></div></a>
                                </div>
                                <?php
                                echo "</span>";
                                echo "</div>";
                            }
                        }
                        ?>
                        <br>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div id="background">
                        <a style="text-decoration:none;" href="friends.php?user_id=<?php echo $user_id; ?>">
                            <div id="buttonfriends">Friends</div>
                        </a>

                        <br>
                        <hr class="strich">

                        <div id=neuerbeitrag> Neuer Beitrag</div>
                        <br>

                        <form id=postbox2 action="hauptseite.php?user_id=<?php echo $my_id; ?>" method="post">
                            <input type="hidden" name="text" value="1">
                            <p id="text1"> Schreibe einen Beitrag :</p>
                            <br>
                            <p><textarea id="post" name="posts" rows="5" cols="80" value=""></textarea></p>
                            <p><input id="button2" type="submit" name="textgesendet" value="Senden">
                                <input id="button3" type="reset" value="Abbruch"></p>
                        </form>
                        <?php
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
                                ?>
                                <div id="beitrag">
                                    <?php
                                    echo 'Danke für deinen Beitrag!';
                                    ?>
                                </div>
                                <?php
                            } else {
                                if ($error === true)
                                    echo '<div id="meldung"> <br><br>Etwas ist schief gelaufen.<br> </div>';
                            }
                        }
                        //Einfügen Bild
                        $upload_ordner = 'bilder/'; //Das Upload-Verzeichnis
                        $tmpname = $_FILES["upfile"] ["name"];
                        $tmpname_teile = explode(".", $tmpname);
                        $endung = $tmpname_teile [count($tmpname_teile) - 1];
                        //Überprüfung der Bildendung
                        $erlaubte_endungen = array('png', 'jpg', 'jpeg', 'gif');
                        if (isset($_POST['bildgesendet'])) {
                            if (!in_array($endung, $erlaubte_endungen)) {
                                ?>
                                <div class="meldung2">
                                <?php
                                die("Achtung: Es sind nur png, jpg, jpeg und gif-Dateien erlaubt.");
                                ?>
                                </div>
                                <?php
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

                            ?>
                            <div class="meldung2">
                                <?php
                                die("Bitte keine Dateien größer 500kb hochladen.");
                                ?>
                            </div>
                            <?php
                        }
                        //Überprüfung, dass das Bild keine Fehler enthält
                        if (isset($_POST["bildgesendet"])) {
                            if (function_exists('exif_imagetype')) {
                                $erlaubte_typen = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
                                $geschuetzte_typen = exif_imagetype($_FILES['upfile']['tmp_name']);
                                if (!in_array($geschuetzte_typen, $erlaubte_typen)) {
                                    ?>
                                    <div class="meldung2">
                                        <?php
                                        die("Nur der Upload von Bilddateien ist gestattet");
                                        ?>
                                    </div>
                                    <?php
                                }
                            }
                        }
                        //Alles okay, verschiebe Bild an neuen Pfad
                        move_uploaded_file($_FILES['upfile']['tmp_name'], $new_path);
                        //echo 'Bild erfolgreich hochgeladen: <a href="'.$new_path.'">'.$new_path.'</a>';
                        ?>
                        <hr class="strich">
                        <form enctype="multipart/form-data"
                              name="uploadformular" action="hauptseite.php?user_id=<?php echo $my_id; ?>" method="post">
                            <input type="hidden" name="picture" value="1">
                            <p id="text2"> Auswahl und Absenden des Bildes:</p>
                            <br>
                            <p><input id=dateiauswahl name="upfile" type="file"></p>
                            <p><input id="button4" type="submit" name="bildgesendet" value="Hochladen">
                                <input id="button5" type="reset" value="Abbruch"></p>
                        </form>

                        <br>
                        <hr class="strich">
                        <div id="friendsbeiträge">Alle Beiträge</div>
                        <br>
                        <div>
                            <?php
                            //Chronik - wo die geposteten Beiträge auftauchen
                            $stmt = $pdo->prepare("SELECT * FROM vlj_beitraglogin WHERE posts IS NOT NULL OR bildtext IS NOT NULL ORDER BY zeitstempel DESC");
                            $result = $stmt->execute();
                            while ($row = $stmt->fetch()) {
                                $userid = $row['login_id'];
                                $show_profilepic = $pdo->prepare ("SELECT * FROM profilbildlogin WHERE login_id = $userid");
                                $show_profilepic->execute();
                                $row4 = $show_profilepic->fetch();
                                if(empty($row['bildtext'])) {
                                    ?>
                                    <div id="postskasten">
                                        <a href="profilseite.php?user_id=<?php echo $userid ?>"><img id="postsprofilbild" src="<?php echo $row4['profilbildtext'] ?>"></a>
                                        <a id="postsbenutzername" href="profilseite.php?user_id=<?php echo $userid ?>"><?php echo $row['benutzername'] ?> </a>
                                        <br>
                                        <div id="postszeit"> <?php echo $row['zeitstempel'] ?> </div>
                                        <br>
                                        <p id="poststext"> <?php echo $row['posts'] ?></p>
                                    </div>

                                    <?php
                                }else {
                                    ?>
                                    <div id="postskasten">
                                        <a href="profilseite.php?user_id=<?php echo $userid ?>"><img id="postsprofilbild" src="<?php echo $row4['profilbildtext'] ?>"></a>
                                        <a id="postsbenutzername" href="profilseite.php?user_id=<?php echo $userid ?>"><?php echo $row['benutzername'] ?> </a>
                                        <br>
                                        <div id="postszeit"> <?php echo $row['zeitstempel'] ?> </div>
                                        <br>
                                        <img id="postsbild" src="<?php echo $row['bildtext'] ?>">
                                    </div>

                                    <?php
                                } }
                            ?>

                            <br>
                        </div>
                    </div>
                </div>


                <div class="col-sm-3">
                    <div id="profile">
                        <h2 class="ueberschriftenmain"> Profile </h2>

                        <div class="name">
                            Benutzername:
                            <?php
                            echo $title['benutzername'];
                            ?>
                        </div>
                        <br>
                        <br>
                        <div class= "adresseneu">
                            E-Mail Adresse:
                            <br>
                            <?php
                            echo $title['hdm_mail'];
                            ?>

                        </div>
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