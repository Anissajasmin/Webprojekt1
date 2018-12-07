<!DOCTYPE html>
<html>
<head>
    <title>Registrierung</title>
    <link rel="stylesheet" type="text/css" href="registrieren.css">

</head>
<body>
    <div id="startseite">
    <div id="header">
        <h1 id="ueberschrift"> TOUCH </h1>

    </div>
    <div id="main">
        <h2 id="unterueberschrift"> Registrierung
        </h2>

        <form action="" method="post">
            <p class="beschriftung"> Benutzername: </p>
            <input class="beschriftung3" type="text" size="25" maxlength="250" name="benutzername" placeholder= "Benutzername" value = "">


            <p class="beschriftung"> HdM E-Mail: </p>
            <input class= "beschriftung3" type="email" size="25" maxlength="250" name="hdm_mail" placeholder= "Hdm E-Mail" value = "">


            <p class="beschriftung"> Passwort: </p>
            <input class= "beschriftung3" type="password" size="25"  maxlength="250" name="passwort" placeholder = "Passwort" value = "">

            <input type="hidden" name="ueberpruefen" value="1">
            <input id=loginbutton type="submit" name = "registrieren" value="Registrieren">

        </form>

<?php
session_start();
    include ("datenbankpasswort.php");

    $benutzername = $_POST['benutzername'];
    $mail = $_POST['hdm_mail'];
    $passwort = $_POST['passwort'];
    $passworthash = password_hash($passwort, PASSWORD_DEFAULT);

    $fehler = false;


        //Wurde der Benutzername schon registriert?

            if (!$fehler) {
                $statement = $pdo->prepare("SELECT benutzername FROM login WHERE benutzername = :benutzername");
                $result = $statement->execute(array(':benutzername' => $benutzername));
                $user = $statement->fetch();


                if ($user !== false) {
                    echo '<div id="meldung"><br>Dieser Benutzername ist bereits vergeben<br></div>';
                    $fehler = true;
                }
            }


        //Wurde die Mailadresse schon registriert?
            if (!$fehler) {
                $statement = $pdo->prepare("SELECT hdm_mail FROM login WHERE hdm_mail = :hdm_mail");
                $result = $statement->execute(array(':hdm_mail' => $mail));
                $mailadress = $statement->fetch();


                if ($mailadress !== false) {
                    echo '<div id="meldung"><br>Diese E-Mail-Adresse ist bereits vergeben<br></div>';
                    $fehler = true;
                }
            }


//Ist die Mailadresse von der HdM?

if(isset($_POST['ueberpruefen'])) {
    $fehler = false;
    $mail_teile = explode( "@", $mail);
    $mail_endung= $mail_teile [count($mail_teile) - 1];
    $mailmail = substr ($mail_endung, -16);

    $xy = "hdm-stuttgart.de";
    $hdmmail = $mailmail !== $xy;

    if($hdmmail) {
        echo '<p id="meldung">Bitte benutze eine HdM-Mailadresse!</p>';
        $fehler = true;

    }
    else {
    }
}



        //Registrierung nur dann erfolgreich, wenn alle Felder ausgefüllt sind!

            $errorfelder = array();
            $felder = array("benutzername", "hdm_mail", "passwort");

            if(isset($_POST['ueberpruefen'])) {
                $fehler = false;

                foreach($felder as $feld) {
                    if(empty($_POST[$feld])) {
                        $fehler = true;
                        $errorfelder[$feld] = true;
                    }
                }
            }

            if($fehler === false) {

                $statement = $pdo->prepare("INSERT INTO login (benutzername, hdm_mail, passwort) VALUES (:benutzername, :hdm_mail, :passwort)");
                $ergebnis = $statement->execute(array(':benutzername' => $benutzername, ':hdm_mail' => $mail, ':passwort' => $passworthash));

                if ($ergebnis) {
                    echo '<div id="meldung"> <br><br>Du wurdest erfolgreich registriert. <a href="login.php">Zum Login</a> </div>';
                }
            } else {

                if ($fehler === true) {
                    echo '<div id="meldung"> <br><br>Bitte fülle alle Felder aus<br> </div>';
                }
                if (strlen($benutzername) <= 3 && strlen($benutzername) >= 32) {
                echo '<div id="meldung"><br><br>Dieser Benutzername ist ungültig<br></div>';
                }
            }



?>
</body>
</html>