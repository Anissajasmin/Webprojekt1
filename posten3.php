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

<form action="posten3.php" method="post">
    <input type="hidden" name="text" value="1">
    <p> Schreibe einen Beitrag (max. 1000 Zeichen):</p>
    <p><textarea name="posts" rows="5" cols="80" value="" ></textarea></p>
    <p><input type="submit" name="textgesendet" value="Senden">
        <input type="reset" value="Abbruch"></p>
</form>

<p><b> oder </b></p>

<form enctype="multipart/form-data"
      action="posten3.php" method="post">
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


            $stmt = $pdo->prepare("SELECT beitrag.*, login.* FROM beitrag, login ORDER BY beitrag.zeitstempel DESC ");

            $result = $stmt->execute();
            while ($row = $stmt->fetch()) {
                echo "<tr>";
                echo "<td>" . $row['benutzername'] . "</td>";
                echo "<td>" . $row['posts'] . "</td>";
                echo "</tr>";
            }
        ?>
    </table>
</div>
</body>
</html>
<?php

//Einfügen Bild

if ()
{
    if ($art == 1){
        //Neuer Name
        $fn = $_FILES["upfile"] ["name"];
        $fn_teile = explode( ".", $fn);
        $fn_endung= $fn_teile [count($fn_teile) - 1];
        if (strtolower ($fn_endung) == "jpg") {
            $fn = "post_" . date("YmdHis") . "." . $fn_endung;


            //In DB einfügen, Bild kopieren

            copy($_FILES["upfile"]["tmp_name"], $fn);
            $statement = $pdo->prepare("INSERT INTO posts (art,posts) VALUES art = :art, posts = :posts");
            $result = $statement->execute(array(":art" => $art, ":posts => $posts" ));


            // Originalgröße ermitteln

            $info = getimagesize($fn);
            $width_alt = $info[0];
            $height_alt = $info[1];


            //Neue Bildgröße festlegen
            if ($width_alt > $height_alt) {
                $width_neu = 320;
                $height_neu = ceil($height_alt * $width_neu / $width_alt);
            } else {
                $height_neu = 240;
                $width_neu = ceil($width_alt * $height_neu / $height_alt);

            }

            // Altes und neues Grafikobjekt erzeugen

            $im_alt = imagecreatefromjpeg($fn);
            $im_neu = imagecreatetruecolor($width_neu, $height_neu);


            //Bild in neuer Größe kopieren, speichern

            imagecopyresampled($im_neu, $im_alt, 0, 0, 0, 0, $width_neu, $height_neu, $width_alt, $height_alt);
            imagejpeg($im_neu, $fn);

            //Grafikobjekt löschen
            imagedestroy($im_alt);
            imagedestroy($im_neu);
        }

        else
            echo "<p> Bild wurde nicht hochgeladen, muss vom Typ JPG sein!</p>";


    }}


    }


?>