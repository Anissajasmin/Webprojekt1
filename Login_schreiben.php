<!DOCTYPE html>
<html>
<head>
    <title>Registrierung</title>
</head>
<body>
<form action="?register=1" method="post">
    Benutzername:<br>
    <input type="text" size="40" maxlength="250" name="benutzername" placeholder="Benutzername"><br><br>
    HdM E-Mail:<br>
    <input type="email" size="40" maxlength="250" name="hdm_mail" placeholder="HdM-Email"> <br><br>
    Dein Passwort:<br>
    <input type="password" size="40"  maxlength="250" name="passwort" placeholder="Passwort"><br><br>

    <input type="submit" value="Abschicken">
</form>

<?php
session_start();
 include ("datenbankpasswort.php");


if(isset($_POST['abschicken'])):
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
            $showFormular = false;
        } else {
             echo 'Beim Registrieren ist leider ein Fehler aufgetreten<br>';
          }
   }

?>
<?php
$showFormular = true;
if($showFormular) {
    ?>

    <?php
} //Ende von if($showFormular)
?>

</body>
</html>