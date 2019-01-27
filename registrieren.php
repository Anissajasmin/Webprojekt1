<!DOCTYPE html>
<html lang="de">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>Registrieren</title>
    <link rel="stylesheet" type="text/css" href="touch.css">
    <link href="bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="bootstrap.min.js"></script>
    <script src="jquery-3.2.1.slim.min.js"></script>


    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
          integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"
            integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
            integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
            crossorigin="anonymous"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>


<body>

<div class="container">
    <div class="row">
        <div class="col-xs-3">
        </div>

        <div class="col-xs-6"
        <div id="headerlogin">
            <h1 id="ueberschriftlogin"> TOUCH </h1>
        </div>
    </div>

    <div class ="col-xs-3">
    </div>
</div>
</div>

<div class="container">
    <div class="row">
        <div class="col-xs-3">
        </div>


        <div class="col-xs-6"
        <div id="main2">

            <h2 id="unterueberschriftregistrieren"> Registrierung</h2>

            <form action="" method="post">

                <br>
                <br>
                <br>
                <br>

                <p class="beschriftung"> Benutzername: </p>
                <input class="beschriftung3" type="text" size="25" maxlength="250" name="benutzername" placeholder= "Benutzername" value = "">


                <p class="beschriftung"> HdM E-Mail: </p>
                <input class= "beschriftung3" type="email" size="25" maxlength="250" name="hdm_mail" placeholder= "Hdm E-Mail" value = "">


                <p class="beschriftung"> Passwort: </p>
                <input class= "beschriftung3" type="password" size="25"  maxlength="250" name="passwort" placeholder = "Passwort" value = "">
                <br>

                <input type="hidden" name="ueberpruefen" value="1">
                <input id=loginbutton type="submit" name = "registrieren" value="Registrieren">

            </form>

        </div>
    </div>

    <?php
    session_start();
    include ("datenbankpasswort.php");
    $benutzername = $_POST['benutzername'];
    $mail = $_POST['hdm_mail'];
    $passwort = $_POST['passwort'];
    $passworthash = password_hash($passwort, PASSWORD_DEFAULT);
    $fehler = false;
    $hash = md5( rand(0,1000) ); //Hash zur Email Verifizierung
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
        $mail_teile = explode("@", $mail);
        if ($mail_teile[1] !== 'hdm-stuttgart.de') {
            echo '<p id="meldung"><br><br>Bitte benutze eine gülitge HdM-Mail!</p>';
            return true;
        }
    }
    // Benutzername zu kurz/lang?
    if(isset($_POST['benutzername'])) {
        if (strlen($benutzername) <= 3){
            echo '<div id= "meldung"><br><br>Dieser Benutzername ist zu kurz. Bitte wähle einen anderen.<br></div>';
            return true;
        }
        if (strlen($benutzername) >= 32) {
            echo '<div id="meldung"><br><br>Dieser Benutzername ist zu lang. Bitte wähle einen anderen.<br></div>';
            return true;
        }
    }
    // Passwort zu kurz/lang?
    if(isset($_POST['passwort'])) {
        if (strlen($passwort) <= 7){
            echo '<div id= "meldung"><br><br>Das Passwort ist zu kurz. Es muss mindestens 8 Zeichen und maximal 20 Zeichen beinhalten.<br></div>';
            return true;
        }
        if (strlen($passwort) >= 21) {
            echo '<div id="meldung"><br><br>Das Passwort ist zu lang. Es muss mindestens 8 Zeichen und maximal 20 Zeichen beinhalten.<br></div>';
            return true;
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
        $statement = $pdo->prepare("INSERT INTO login (benutzername, hdm_mail, passwort, hash, aktiviert) VALUES (:benutzername, :hdm_mail, :passwort, :hash, 0)");
        $statement->bindParam(':benutzername', $benutzername);
        $statement->bindParam(':hdm_mail', $mail);
        $statement->bindParam(':passwort', $passwort);
        $statement->bindParam(':hash', $hash);
        $ergebnis = $statement->execute(array(':benutzername' => $benutzername, ':hdm_mail' => $mail, ':passwort' => $passworthash, ':hash' => $hash));
        if ($ergebnis) {
            echo '<div id="meldung"> <br><br>Du wurdest erfolgreich registriert. Du hast eine EMail bekommen. Bitte aktiviere deinen Account</a> </div>';

            // Email Verifizieren lassen
            $to      = $mail; // Empfänger der Mail
            $subject = 'Email wurde verifiziert'; // Betreff
            $message = '
 
                Danke, dass du dich bei Touch registriert hast!
                Dein Account wurde bei uns angelegt. Mit deinem Benutzernamen und Passwort kannst du dich einloggen, sobald du den untenstehenden Link zur Aktivierung deines Accounts geklickt hast!
 
                ------------------------
                Benutzername: '.$benutzername.'
                Passwort: '.$passwort.'
                ------------------------
 
                Bitte klicke auf den Link, um deinen Account bei uns zu aktivieren:
                https://mars.iuk.hdm-stuttgart.de/~nk093/Webprojekt1/aktivierung.php?mail='.$mail.'&hash='.$hash.'
 
                '; // Die Nachricht der Email
            $headers = 'From:deinteam@touch.de' . "\r\n"; // Von wem wirds verschickt?
            mail($to, $subject, $message, $headers); // Die Email wird gesendet
        }
    } else {
        if ($fehler === true) {
            echo '<div id="meldung"> <br><br>Bitte fülle alle Felder aus<br> </div>';
        }
    }

    ?>
</body>
</html>