<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profilseite</title>
    <link rel="stylesheet" type="text/css" href="settings.css">
    <meta name = "viewport" content="width-device-width, initial-scale=1.0, maximum-scale=1.0, user scalelable=no">
</head>

<?php
include "includedesign.php";
?>

<?php
include "datenbankpasswort.php";
?>


<?php
session_start();
include_once "logincheck.php";
if (!isset($_SESSION['login-id'])) {
    echo "Bitte logge dich ein oder registriere dich zuerst. <a href=\"Startseite.php\">Zur Startseite</a>";
}else{
?>


<body>


<div id="settings">

    <div class id="header">
        <h1>TOUCH </h1>

        <div id="searcharea" class="header"><input placeholder="Search here..." type="text" id="searchbox"/></div>


        <a style="text-decoration:none;" href="">
            <div id="notificationneu"><img src="notificationneu.png"/>
                <div>
        </a>


        <a style="text-decoration:none;" href="">
            <div id="messageneu"><img src="messageneu.png"/>
                <div>
        </a>


        <a style="text-decoration:none;" href="">
            <div id="settingneu"><img src="settingneu.png"/>
                <div>
        </a>


    </div>

    <div class="header1"
</div>
<div class="coverpad">
</div>


<div id="main">

    <div id="recommendation">
        <h2 class="ueberschriftenmain"> Recommendations
        </h2>
    </div>
</div>


<div id="background">

    <a style="..." href="">
        <div class="button1">Save</div>
    </a>

    <br>
    <hr class="strich">

    <div class="button10"></div>
    <div id="ueberschrift">
        <h3> Settings </h3>
    </div>


    <form enctype="multipart/form-data"
          name="uploadformular" action="profilseite.php?user_id=<?php echo $user_id;?>" method="post">
        <p><input id=dateiauswahl name="upfile" type="file"></p>
        <p><input id="button9" type="submit" name="bildgesendet" value="Hochladen">
    </form>

    <label class="switch">
        <input class="switch-input" type="checkbox"/>
        <span class="switch-label" data-on="On" data-off="Off"></span>
        <span class="switch-handle"></span>
    </label>

    <div id="tabellename">


        <?php
        echo $_SESSION["username"];
        ?>

    </div>


    <div id="tabelleemail">

        <?php
        echo $_SESSION["mail"];
        ?>


    </div>

</body>

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

//In DB einfügen

        $statement = $pdo->prepare("INSERT INTO profilbild (profilbildtext, user_id) VALUES ('$new_path', '$user_id')");
        $result = $statement->execute();
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

<div>
    <?php //Chronik - wo die geposteten Bilder auftauchen


    $stmt = $pdo->prepare("SELECT * FROM profilbildlogin WHERE profilbildtext IS NOT NULL ");

    $result = $stmt->execute();
    while ($row = $stmt->fetch()) {
        echo "<div id=\"button9\">";
        echo "<img src='" . $row['profilbildtext'] . "'height='120' 'weight: 120'>";
        echo "</div>";
    }
    }
    ?>

</div>
