<!DOCTYPE html>
<html>
<head>
    <title>Registrierung</title>
    <link rel="stylesheet" type="text/css" href="Login_schreiben.css">


</head>
<body>
<div id="startseite">
    <div id="header">
        <h1 id="ueberschrift"> TOUCH </h1>

    </div>
    <div id="main">
        <h2 id="unterueberschrift"> Registrierung
        </h2>



        <form action="?register=1" method="post">
            <p class="beschriftung"> Benutzername: </p>
            <input class="beschriftung3" type="text" size="25" maxlength="250" name="benutzername" placeholder= "Benutzername" value="" >


            <p class="beschriftung"> HdM E-Mail: </p>
            <input class= beschriftung3 type="email" size="25" maxlength="250" name="hdm_mail" placeholder= "Hdm E-Mail" value="">


            <p class="beschriftung"> Passwort: </p>
            <input class= beschriftung3 type="password" size="25"  maxlength="250" name="passwort" placeholder = "Passwort" value="" >

            <input id=loginbutton type="submit" value="Registrieren">
        </form>


        <?php
session_start();
 include ("datenbankpasswort.php");


if(isset($_POST['Registrieren'])):
    $error = false;
    $benutzername = $_POST['benutzername'];
    $passwort = $_POST['passwort'];
    $mail = $_POST['hdm_mail'];

    //Wurde die Mailadresse schon registriert?
    if(!$error) {
        $statement = $pdo->prepare("SELECT * FROM login WHERE hdm_mail = :hdm_mail");
        $result = $statement->execute(array('hdm_mail' => $mail));
        $benutzername = $statement->fetch();

      if($benutzername !== false) {
        echo 'Diese E-Mail-Adresse ist bereits vergeben<br>';
        $error = true;
      }
    }endif;

$registererror=false;
$benutzername = $_POST['benutzername'];
$passwort = $_POST['passwort'];
$mail = $_POST['hdm_mail'];

    //Registierung erfolgreich
    if(!$registererror) {

         $statement = $pdo->prepare("INSERT INTO login (benutzername, hdm_mail, passwort) VALUES (:benutzername, :hdm_mail, :passwort)");
         $result = $statement->execute(array('benutzername' => $benutzername, 'hdm_mail' => $mail, 'passwort' => $passwort));

         if($result) {
            echo 'Du wurdest erfolgreich registriert. <a href="Login_lesen.php">Zum Login</a>';
        } else {
             if($benutzername="" OR $mail="" OR $passwort=""){
             echo 'Beim Registrieren ist leider ein Fehler aufgetreten<br>';
          }}
   }

?>

</body>
</html>