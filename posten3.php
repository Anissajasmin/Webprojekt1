<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Beitrag Posten</title>
    <link rel="stylesheet" type="text/css" href="hauptseite.css">

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

            $stmt = $pdo->prepare("SELECT * FROM vlj_beitraglogin ORDER BY zeitstempel DESC ");

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

if (array_key_exists('upfile',$_FILES)) {

    $tmpname = $_FILES['upfile']['tmp_name'];

    $type = $_FILES['upfile']['type'];

    $hndFile = fopen($tmpname, "r");

    $data = addslashes(fread($hndFile, filesize($tmpname)));

    $statement = $pdo->prepare("INSERT INTO beitrag (bild, bildtext, user_id) VALUES ('$data', '$type', '$user_id')");
    $result = $statement->execute();

}

else {
    echo "<p> Bild wurde nicht hochgeladen, muss vom Typ JPG sein!</p>";
}


?>
<div>
    <table>
        <tr>
            <th>Benutzername</th>
            <th>Bild</th>
        </tr>

        <?php
        //Chronik - wo die geposteten Bilder auftauchen


        $stmt = $pdo->prepare("SELECT * FROM vlj_beitraglogin ORDER BY zeitstempel DESC");

        $result = $stmt->execute();
        while ($row = $stmt->fetch()) {
            echo "<tr>";
            echo "<td>" . $row["benutzername"] . "</td>";

            echo "<td><img src='" . $row["bild"] . "'></td>";
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