
<?php
session_start();
include ("datenbankpasswort.php");
    array('charset'=>'utf8');
?>



<?php
if(isset($_POST["Hochladen"])) {
    move_uploaded_file($_FILES["file"],["tmp_name"], "pictures/".$_FILES["file"], ["name"]);
    $con = mysqli_connect( "u-nk093", "u-nk093", "", "u-nk093");
    $q = mysqli_query($con, "Update users SET image = ". $_FILES["file"] ["name"]."  WHERE username = ".$_SESSION["benutzername"]." ");
}
?>


<!doctype html>
<html lang ="de">
    <head>
        <meta charset="utf-8">
        <title>Profilbild ändern </title>
    </head>
    <body>
<form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="file">
        <input type="Hochladen" name="Hochladen">

</form>

<?php
$statement = $pdo->prepare("INSERT INTO benutzer (id, benutzername, profilbild) VALUES (?, ?, ?)");
$datensatz=array("1", "Max", "");
$statement->execute($datensatz);
?>



</body>
</html>



