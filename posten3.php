<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Beitrag Posten</title>

    <?php
    if (isset($_POST["Senden"])) {
        include("datenbankpasswort.php");

        //Einfügen des Textes

        $art = ($_POST['art']) ;
        if ($art == 0) {
            $text = true;
        }
        if ($art == 1) {
            $text = false;
        }
        $posts = $_POST ['posts'];
    }

        if ($text = true) {

        $statement = $pdo->prepare("INSERT INTO posts (art,posts) VALUES art = :art, posts = :posts");
        $result = $statement->execute(array(':art' => $art, ':posts' => $posts ));

        }

        //Einfügen Bild

        else
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



    ?>

</head>
<body>
<p align="center"> <b> Neuer Beitrag</b></p>

<form action="posten3.php" method="post">
    <input type="hidden" name="art" value="0">
    <p> Schreibe einen Beitrag (max. 1000 Zeichen):</p>
    <p> <textarea name="posts" rows="5" cols="80"></textarea></p>
    <p> <input type="submit" name="gesendet" value="Senden">
        <input type="reset" value="Abbruch"></p>
</form>

<p> <b> oder </b></p>

<form enctype="multipart/form-data"
      action="posten3.php" method="post">
    <input type="hidden" name="art" value="1">
    <p> Auswahl und Absenden des Bildes:</p>
    <p> <input name="upfile" type="file"> </p>
    <p> <input type="submit" name="gesendet" value="Senden">
        <input type="reset" value="Abbruch"></p>
</form>

</body>
</html>
