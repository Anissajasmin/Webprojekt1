
<?php

session_start();

    include ("datenbankpasswort.php");
        if (isset($_POST["benutzername"]) AND isset($_POST["passwort"])) {
            $benutzername = $_POST["benutzername"];
            $passwort = $_POST["passwort"];
            $passworthash = password_hash($passwort, PASSWORD_DEFAULT);

            $search = $pdo->prepare("SELECT benutzername, passwort, active FROM login WHERE benutzername='" . $benutzername . "' AND passwort='" . $passwort . "' AND aktiviert = '1'");
            $match = $search->execute();

            }

//Es werden Benutzername und Passwort überprüft und bei richtiger Eingabe, eine Session gesetzt und zur Hauptseite weitergeleitet

if($match > 0){

    if ($search->execute(array(':benutzername' => $benutzername))) {
        if ($row = $search->fetch()) {
            $passwortdatenbank = $row["passwort"];
            password_verify ($passwort, $passwortdatenbank);

            if (password_verify ($passwort, $passwortdatenbank)) {
                $_SESSION["login-id"] = $row["login_id"];
                header('Location: hauptseite.php');
            }
            }
        }
    }else {
    echo '<p id="meldung">Deine eingegebenen Daten sind leider falsch oder du hast den Link in der Aktivierungsmail noch nicht bestätigt.. Probiers nochmal oder <a href="registrieren.php">registriere dich zuerst.</a></p><br>';
}

?>