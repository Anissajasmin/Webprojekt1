<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profilseite</title>
    <link rel="stylesheet" type="text/css" href="settings.css">
    <link rel="stylesheet" type="text/css" href="profilseite.css">
    <meta name = "viewport" content="width-device-width, initial-scale=1.0, maximum-scale=1.0, user scalelable=no">
</head>
<?php
session_start();
include_once "logincheck.php";
if (!isset($_SESSION['login-id'])) {
    echo "Bitte logge dich ein oder registriere dich zuerst. <a href=\"Startseite.php\">Zur Startseite</a>";
}else {
include("datenbankpasswort.php");
include "header.php";
?>

<body>

<div id="main">

    <div id="recommendation">
        <h2 class="ueberschriftenmain"> Recommendations
        </h2>
        <?php

        //Nutzer, denen man noch nicht folgt werden hier angezeigt
        //Wird dem Benutzer bereits gefolgt?

        $checkfollow = $pdo->prepare("SELECT * FROM follow WHERE follow_id='" . $my_id . "'");
        $checkfollow->execute();

        $notfollowing = $checkfollow->rowCount();

        if (!$notfollowing > 0) {
            $showallusers = $pdo->prepare ("SELECT * FROM login WHERE NOT login_id = $my_id");
            $showallusers->execute();
            while ($row1 = $showallusers->fetch()){
                $allusers = $row1['login_id'];
                echo "<div id=\"tabelleposts\">";
                echo "<span>";
                ?>
                <div id="kasten">
                    <a style="text-decoration:none;" href="profilseite.php?user_id=<?php echo $allusers ?>"><div id="kastentext"><?php echo $row1['benutzername'] ?></div></a>

                </div>
                <?php
                echo "</span>";
                echo "</div>";

            }
        }else{
            $row = $checkfollow->fetch();
            $userid = $row['user_id'];
            $my_id = $row ['follow_id'];
            //Wenn man jemandem nicht folgt, werden die Namen der Personen, denen man nicht folgt, in dieser Liste angezeigt
            $show_users = $pdo->prepare("SELECT * FROM login WHERE NOT login_id = $my_id AND NOT login_id = $userid");
            $show_users->execute();

            while($row3 = $show_users->fetch()) {
                $users = $row3['login_id'];
                echo "<div id=\"tabelleposts\">";
                echo "<span>";
                ?>
                <div id="kasten">
                    <a style="text-decoration:none;" href="profilseite.php?user_id=<?php echo $users ?>"><div id="kastentext"><?php echo $row3['benutzername'] ?></div></a>

                </div>
                <?php
                echo "</span>";
                echo "</div>";

            }
        }

        ?>
    </div>


    <div id="background">

        <a style="..." href="profilseite.php?user_id=<?php echo $user_id; ?>"">
        <div class="button1">Save</div>
        </a>

        <br>
        <hr class="strich">

        <div class="button10"></div>
        <div id="ueberschrift">
            <h3> Settings </h3>
        </div>


        <form enctype="multipart/form-data"
              name="uploadformular" action="" method="post">
            <p><input id=dateiauswahl name="upfile" type="file"></p>
            <p><input id="button9" type="submit" name="bildgesendet" value="Hochladen">
        </form>

        <label class="switch">
            <input class="switch-input" type="checkbox"/>
            <span class="switch-label" data-on="On" data-off="Off"></span>
            <span class="switch-handle"></span>
        </label>

        <div id="tabellename1">


            <?php
            echo $_SESSION["username"];
            ?>

        </div>


        <div id="tabelleemail1">

            <?php
            echo $_SESSION["mail"];
            ?>

        </div>


        <?php
        $user_id = $_SESSION["login-id"];

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
                $bildname = "profilbild_" . date("YmdHis") . $endung;

//Pfad zum Upload
                $new_path = $upload_ordner . $bildname . '.' . $endung;

//In DB einfügen bzw. updaten, falls ein Profilbild bereits hochgeladen wurde
            }
        }
        $stmt = $pdo->prepare("SELECT profil_user_id FROM profilbild WHERE profil_user_id = :profil_user_id");
        $result = $stmt->execute(array(':profil_user_id' => $my_id));
        $ergebnis = $stmt->fetch();

        if (isset($_POST['bildgesendet'])) {

            if ($ergebnis !== false) {
                $update = $pdo->prepare("UPDATE profilbild SET profilbildtext = :profilbildtext WHERE profil_user_id = :profil_user_id");
                $update->bindParam(':profilbildtext', $new_path);
                $update->bindParam(':profil_user_id', $my_id);
                if ($update->execute()) {
                    echo "Dein Profilbild wurde erfolgreich geändert";
                }
            } else {

                $statement = $pdo->prepare("INSERT INTO profilbild (profilbildtext, profil_user_id) VALUES ('$new_path', '$my_id')");
                $statement->bindParam(':profilbildtext', $new_path);
                $statement->bindParam(':profil_user_id', $my_id);
                $result = $statement->execute();
                echo "Dein Bild wurde erfolgreich hochgeladen";
            }
        }

        //Überprüfung der Dateigröße, nicht größer als 500 kB
        $max_size = 500 * 1024;
        if ($_FILES['upfile']['size'] > $max_size) {
            die("Bitte keine Dateien größer 500kb hochladen.");
        }

        //Überprüfung dass das Bild keine Fehler enthält
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



        $statement = $pdo->prepare("SELECT * FROM 'benutzerdaten' WHERE my_id= $my_id");
        $statement->execute();
        $benutzerdaten = $statement->rowCount();
        if($benutzerdaten){
            while ($row2 = $statement->fetch()) {
                $datenvorname= $row2['vorname'];
                $datennachname= $row2['nachname'];
                $datenstudiengang = $row2['studiengang'];
                $datensemester = $row2['semester'];
                }}
                ?>
                <p>
                    Hier kannst du dein Profil bearbeiten.
                </p>

                <br>

                <form action="" method="post">
                    <table>
                        <tr>
                            <td class="benennung">Vorname:</td>
                            <td><input class="eingabefeld" type="text" name="vorname"
                                       placeholder="<?php echo $datenvorname; ?>">
                            </td>

                        </tr>

                        <tr>
                            <td class="benennung">Nachname:</td>
                            <td><input class="eingabefeld" type="text" name="nachname"
                                       placeholder="<?php echo $datennachname; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td class="benennung">Studiengang:</td>
                            <td><input class="eingabefeld" type="text" name="studiengang" id="subject"
                                       placeholder="<?php echo $datenstudiengang; ?>">
                            </td>
                        </tr>

                        <tr>
                            <td class="benennung">Semester:</td>
                            <td><input class="eingabefeld" type="number" name="semester" id="semester" min="1" max="10"
                                       placeholder="<?php echo $datensemester; ?>">
                            </td>
                        </tr>

                    </table>

                    <br>

                    <p><input type="submit" name="newchanges" value="Speichern"></p>

                </form>


                <?php

    // Profildaten bearbeiten

    $stmt = $pdo -> prepare ("SELECT * FROM benutzerdaten WHERE my_id = $my_id");
    $ergebnis = $stmt->execute();
    $vorhanden = $stmt->fetch();

    if (isset ($_POST["newchanges"])) {

$vorname = $_POST['vorname'];
$nachname = $_POST['nachname'];
$studiengang = $_POST['studiengang'];
$semester = $_POST['semester'];

    if (empty($_POST["vorname"]) && empty($_POST["nachname"]) && empty($_POST["studiengang"]) && empty($_POST["semester"])) {

?>
        <br>
        <div>
            <strong> Achtung! </strong> Fülle alle Felder aus!
        </div>

        <?php
        } else {
        if ($vorhanden !== false) {

        $updatedaten = $pdo->prepare("UPDATE benutzerdaten SET vorname = :vorname, nachname = :nachname, studiengang = :studiengang, semester = :semester WHERE my_id = :my_id");
        $updatedaten->bindParam(':vorname', $vorname);
        $updatedaten->bindParam(':nachname', $nachname);
        $updatedaten->bindParam(':studiengang', $studiengang);
        $updatedaten->bindParam(':semester', $semester);
        $updatedaten->bindParam(':my_id', $my_id);

        if ($updatedaten->execute()) {
        ?>
        <br>
        <div>
            Du hast dein Profil geupdated!
        </div>
        <?php
        }
        } else {
            if ($vorhanden == false) {
            $insertdaten = $pdo->prepare("INSERT INTO benutzerdaten (vorname, nachname, studiengang, semester, my_id) VALUES ('$vorname', '$nachname', '$studiengang', '$semester', '$my_id')");
            $insertdaten->bindParam(':vorname', $vorname);
            $insertdaten->bindParam(':nachname', $nachname);
            $insertdaten->bindParam(':studiengang', $studiengang);
            $insertdaten->bindParam(':semester', $semester);
            $insertdaten->bindParam(':my_id', $my_id);
            $execute= $insertdaten->execute(array(':vorname' => $vorname, ':nachname' => $nachname, ':studiengang' => $studiengang, ':semester' => $semester, ':my_id'=>$my_id));

            if ($execute) {
                ?>
                <br>
                <br>
                <div>
                    Du hast dein Profil angepasst!
                </div>
                <?php
            }
            }
        }
        }
        }
?>
    </div>

    <div id="profile">
        <h2 class="ueberschriftenmain"> Profile
        </h2>

        <div id="tabellename1">
            <?php
            echo $title['benutzername'];
            ?>
        </div>

        <div id="tabelleemail1">
            <?php
            echo $title['hdm_mail'];
            ?>

        </div>

    </div>

</div>


</body>

</html>
<?php
}
?>

