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
include "header.php";
session_start();
include_once "logincheck.php";
if (!isset($_SESSION['login-id'])) {
    echo "Bitte logge dich ein oder registriere dich zuerst. <a href=\"Startseite.php\">Zur Startseite</a>";
}else {
include("datenbankpasswort.php");
?>

<body>

<div id="main">

    <div id="recommendation">
        <h2 class="ueberschriftenmain"> Recommendations
        </h2>
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


        ?>

        <p>
            Hier kannst du dein Profil bearbeiten.
        </p>


        <br>
        <br>
        <table>

            <tr>
                <td class="benennung">Vorname:</td>
                <td><input class="eingabefeld" type="text" name="vorname" placeholder="<?php echo $row['vorname'] ?>">
                </td>
            </tr>


            <tr>
                <td class="benennung">Nachname:</td>
                <td><input class="eingabefeld" type="text" name="nachname" placeholder="<?php echo $row['nachname'] ?>">
                </td>
            </tr>

            <tr>
                <td class="benennung">Studiengang:</td>
                <td><input class="eingabefeld" type="text" name="studiengang" id="subject"
                           placeholder="<?php echo $row['studiengang'] ?>"
                </td>
            </tr>

            <tr>
                <td class="benennung">Semester:</td>
                <td><input class="eingabefeld" type="number" name="semester" id="semester" min="1" max="10"
                    "<?php echo $row['semester'] ?>"
                </td>
                <br>
            </tr>

        </table>

        <br>
        <br>

        <button type="submit" name="newchanges">Speichern</button>


        <?php
        // Profildaten bearbeiten
        if (isset ($_POST["newchanges"])) {

            $user_id = $_SESSION["login-id"];


            $vorname = $_POST['Vorname'];
            $nachname = $_POST['Nachname'];
            $studiengang = $_POST['Studiengang'];
            $semester = $_POST['Semester'];

            if (empty($_POST["Vorname"]) OR empty($_POST["Nachname"]) OR empty($_POST["Studiengang"]) OR empty($_POST["Semester"])) {

                ?>
                <br>
                <br>
                <div>
                    <strong> Achtung! </strong> Fülle alle Felder aus!


                </div>

                <?php
            } else {

                $updatedprofile = $pdo->prepare("INSERT INTO benutzerdaten (Vorname, Nachname, Studiengang, Semester) VALUES (:Vorname, :Nachname, :Studiengang, :Semester");


                $updatedprofile->bindParam('Vorname', $vornamername);
                $updatedprofile->bindParam('Nachname', $nachname);
                $updatedprofile->bindParam('Studiengang', $studiengang);
                $updatedprofile->bindParam('Semester', $semester);


                $updatedprofile->execute();

                $checkprofil = $pdo->prepare("SELECT 'Vorname', 'Nachname', 'Studiengang', 'Semester' FROM benutzerdaten WHERE my_id='" . $user_id . "'");
                $checkprofil->execute();
                $row2 = $checkprofil->fetch();


                $newvorname = $row2["Vorname"];
                $newnachname = $row2["Nachname"];
                $newstudiengang = $row2["Studiengang"];
                $newsemester = $row2["Semester"];


                if ($newvorname == $_POST['Vorname'] AND $newnachname == $_POST['Nachname'] AND $newstudiengang == $_POST['Studiengang'] AND $newsemester == $_POST['Semester']) {
                    ?>
                    <br>
                    <br>

                    <div>
                        Du hast dein Profil geupdated!
                    </div>
                    <?php

                } else {
                    ?>

                    <br>
                    <br>
                    <div>
                        Etwas ist schief gelaufen!
                    </div>
                    <?php

                }
            }
        }

        // Daten des Nutzers anzeigen

        $statement = $pdo->prepare("SELECT 'Vorname', 'Nachname', 'Studiengang', 'Semester' FROM 'benutzerdaten' WHERE my_id='" . $user_id . "'");
        if ($statement->execute()) {
        while ($row = $statement->fetch()) {
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
<?php
}
}
?>
</html>
<?php
}
?>

