<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Beitrag Posten</title>

    <?php
    session_start();
    include_once "logincheck.php";
    if (!isset($_SESSION["login-id"])) {
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
<p align="center"><b> Neuer Beitrag</b></p>

<form  action="posten3.php" method="post">
    <input type="hidden" name="text" value="1">
    <p> Schreibe einen Beitrag (max. 1000 Zeichen):</p>
    <p><textarea name="posts" rows="5" cols="80" value="" ></textarea></p>
    <p><input type="submit" name="textgesendet" value="Senden">
        <input type="reset" value="Abbruch"></p>
</form>

<p><b> oder </b></p>

<form enctype="multipart/form-data"
      name = "uploadformular" action="posten3.php" method="post">
    <input type="hidden" name="picture" value="1">
    <p> Auswahl und Absenden des Bildes:</p>
    <p><input name="upfile" type="file"></p>
    <p><input type="submit" name="bildgesendet" value="Hochladen">
        <input type="reset" value="Abbruch"></p>
</form>

<br>
<hr>
<div>
    <table>
        <tr>
            <th>Benutzername</th>
            <th>Text</th>
        </tr>

        <?php
        //Chronik - wo die geposteten Beiträge auftauchen

            $stmt = $pdo->prepare("SELECT * FROM vlj_beitraglogin WHERE posts IS NOT NULL ORDER BY beitrag_id DESC ");

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
</body>
</html>
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
    $result = $statement->execute();
}}
//Überprüfung der Dateigröße, nicht größer als 500 kB
$max_size = 500*1024;
if($_FILES['upfile']['size'] > $max_size) {
    die("Bitte keine Dateien größer 500kb hochladen.");
}

//Überprüfung dass das Bild keine Fehler enthält
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


<div>
    <table>
        <tr>
            <th>Benutzername</th>
            <th>Bild</th>
        </tr>

        <?php
        //Chronik - wo die geposteten Bilder auftauchen


        $stmt = $pdo->prepare("SELECT * FROM vlj_beitraglogin WHERE bildtext IS NOT NULL ORDER BY beitrag_id DESC");

        $result = $stmt->execute();
        while ($row = $stmt->fetch()) {
            echo "<tr>";
            echo "<td>" . $row["benutzername"] . "</td>";

            echo "<td><img src='" .$row['bildtext']. "'></td>";
            echo "</tr>";
        }
        ?>
    </table>


</div>
<br>
<br>
<div> Hier kannst du dich <a href="logout.php">ausloggen</a></div>

<?php
    }



?>