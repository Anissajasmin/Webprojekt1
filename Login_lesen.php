<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="Login_lesen.css">
</head>
<body>

<?php
if(isset($errorMessage)) {
    echo $errorMessage;
}
?>
<body>
<div id="startseite">
    <div id="header">
        <h1 id="ueberschrift"> TOUCH </h1>

    </div>
    <div id="main">
        <h2 id="unterueberschrift"> Login
        </h2>



        <form action="?login=1" method="post">
            <p class="beschriftung"> Benutzername: </p>
            <input class="beschriftung2" type="text" size="25" maxlength="250" name="benutzername" ><br><br>

            <p class="beschriftung"> Dein Passwort: </p>
            <input class="beschriftung2" type="password" size="25"  maxlength="250" name="passwort" ><br><br>

            <input id="loginbutton" type="submit" value="Get in touch">
        </form>
    </div>


</body>
</html>

<?php
session_start();

include ("datenbankpasswort.php");

if(isset($_GET['login'])) {
    $benutzername = $_POST['benutzername'];
    $passwort = $_POST['passwort'];

    $statement = $pdo->prepare("SELECT * FROM login WHERE benutzername = :benutzername");
    $result = $statement->execute(array('benutzername' => $benutzername));
    $benutzername = $statement->fetch();

    //Überprüfung des Passworts
    if ($benutzername !== false && password_verify($passwort, $benutzername ['passwort'])) {
        $_SESSION['benutzername'] = $benutzername['id_login'];
        die('Login erfolgreich. Weiter zu <a href="geheim.php">internen Bereich</a>');
    } else {
        $errorMessage = "Benutzername oder Passwort war ungültig<br>";
    }

}
?>
