<?php
if(isset($_REQUEST['submit']))
{
    $filename=  $_FILES["imgfile"]["name"];
    if ((($_FILES["imgfile"]["type"] == "image/gif")|| ($_FILES["imgfile"]["type"] == "image/jpeg") || ($_FILES["imgfile"]["type"] == "image/png")  || ($_FILES["imgfile"]["type"] == "image/pjpeg")) && ($_FILES["imgfile"]["size"] < 200000))
    {
        if(file_exists($_FILES["imgfile"]["name"]))
        {
            echo "File name exists.";
        }
        else
        {
            move_uploaded_file($_FILES["imgfile"]["tmp_name"],"uploads/$filename");
            echo "Upload Successful . <a href='uploads/$filename'>Click here</a> to view the uploaded image";
        }
    }
    else
    {
        echo "invalid file.";
    }
}
else
{
    ?>
    <form method="post" enctype="multipart/form-data">
        File name:<input type="file" name="imgfile"><br>
        <input type="submit" name="submit" value="upload">
    </form>
    <?php
}
?>

<?php




$upload_folder = 'upload/'; //Das Upload-Verzeichnis
$filename = pathinfo($_FILES['datei']['name'], PATHINFO_FILENAME);
$extension = strtolower(pathinfo($_FILES['datei']['name'], PATHINFO_EXTENSION));

//Einfügen Bild
//Neuer Name
$tmpname = $_FILES["upfile"] ["name"];
$tmpname = explode( ".", $tmpname);
$tmpname_endung= $tmpname_teile [count($tmpname_teile) - 1];
if (strtolower ($tmpname_endung) == "jpg") {
$bildname = "post_" . date("YmdHis") . "." . $tmpname_endung;





//In DB einfügen, Bild kopieren

copy($_FILES["upfile"]["tmp_name"], $fn);
$statement = $pdo->prepare("INSERT INTO beitrag (bild, bildtext, user_id) VALUES ('$fn', '$fn', '$user_id')");
$result = $statement->execute();

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

else {
echo "<p> Bild wurde nicht hochgeladen, muss vom Typ JPG sein!</p>";
}

}
?>
