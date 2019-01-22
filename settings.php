<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Einstellungen</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="hauptseite.css">
</head>

<?php
session_start();
include_once "logincheck.php";
if (!isset($_SESSION['login-id'])) {
    echo "Bitte logge dich ein oder registriere dich zuerst. <a href=\"Startseite.php\">Zur Startseite</a>";
}else {
include("datenbankpasswort.php");
include_once "header.php";
include "follow.php";

?>


<body>
<div id="main">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div id="recommendationsprofilseite">
                    <h2 class="ueberschriftenmain"> Recommendations
                    </h2>
                </div>
            </div>


            <div class="col-md-6">
                <div id="backgroundneu">
                    <div id="ueberschrift">
                        Einstellungen
                    </div>


                    <div id="profilbild1">

                    </div>
                    <div>

                        <?php
                        //Profilbild soll hier angezeigt werden

                        $stmt = $pdo->prepare("SELECT * FROM profilbildlogin WHERE profil_user_id = $user_id ");

                        $result = $stmt->execute();
                        while ($row = $stmt->fetch()) {
                            ?>
                            <a><img id="profilbild1" src="<?php echo $row['profilbildtext'] ?>"></a>
                            <?php
                        }

                        ?>
                    </div>
                    <div id="benutzernameprofil">
                        <?php
                        echo $title['benutzername'];
                        ?>
                    </div>

                    <div id="benutzernamemail">

                        <?php
                        echo $title['hdm_mail'];
                        ?>

                    </div>

                    <br>
                    <hr class="strich4">

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

                    <form enctype="multipart/form-data"
                          name="uploadformular"  method="post">
                        <input type="hidden" name="picture" value="1">
                        <p id="text2"> Profilbild ändern:</p>
                        <br>
                        <p><input id="dateiauswahl" name="upfile" type="file"></p>
                        <p><input id="button4" type="submit" name="bildgesendet" value="Hochladen">
                            <input id="button5" type="reset" value="Abbruch"></p>
                    </form>

                    <hr class="strich5">

                    <p id="text3"> Profil bearbeiten:</p>

                    <table id="profildatenneu1">


                        <tr>
                            <td class="benennung1">Vorname:</td>
                            <td><input class="eingabefeld" type="text" name="vorname"
                                       placeholder="<?php echo $row['vorname'] ?>">
                            </td>
                        </tr>
                        <tr>
                            <td class="benennung1">Nachname:</td>
                            <td><input class="eingabefeld" type="text" name="nachname"
                                       placeholder="<?php echo $row['nachname'] ?>">
                            </td>
                        </tr>
                        <tr>
                            <td class="benennung1">Studiengang:</td>
                            <td><input class="eingabefeld" type="text" name="studiengang" id="subject"
                                       placeholder="<?php echo $row['studiengang'] ?>"
                            </td>
                        </tr>
                        <tr>
                            <td class="benennung1">Semester:</td>
                            <td><input class="eingabefeld" type="number" name="semester" id="semester" min="1" max="10"
                                "<?php echo $row['semester'] ?>"
                            </td>
                            <br>
                        </tr>
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
        <?php
}}}
 ?>

                    </table>

                    <button id="speichern" name="newchanges">Speichern</button>
                    <br>
                    <br>

                    <hr class="strich3">


                </div>
            </div>


            <div class="col-sm-3">
                <div id="anzeigederbeiträgeundfreunde">
                    <h2 class="ueberschrift1"> Anzahl deiner Freunde:
                        <h2 id="buttonfriendsneu">
                            <div class="anzahl">
                                <?php
                                $anzahlfriends = $pdo->prepare("SELECT ALL * FROM follow WHERE follow_id = $my_id ");
                                $anzahlfriends->execute();
                                $showanzahlfriends= $anzahlfriends->rowCount();
                                echo $showanzahlfriends;
                                ?>
                            </div>
                        </h2>
                    </h2>
                    <h3 class="ueberschrift2"> Anzahl deiner Beiträge:
                        <h2 id="buttonpostsneu">
                            <div class="anzahl">
                                <?php
                                $anzahlposts = $pdo->prepare("SELECT ALL * FROM beitrag WHERE beitrag_user_id = $my_id ");
                                $anzahlposts->execute();
                                $showanzahlposts= $anzahlposts->rowCount();
                                echo $showanzahlposts;
                                ?>
                            </div>
                        </h2>
                    </h3>

                </div>
            </div>iv>
            </div>
        </div>
    </div>

</body>
</html>

<br>
<br>



