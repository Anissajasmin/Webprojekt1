
<?php

session_start();

    include ("datenbankpasswort.php");
        if (isset($_POST["benutzername"]) AND isset($_POST["passwort"])) {
            $benutzername = $_POST["benutzername"];
            $passwort = $_POST["passwort"];
            $passworthash = password_hash($passwort, PASSWORD_DEFAULT);
        }

//Es werden Benutzername und Passwort überprüft und bei richtiger Eingabe, eine Session gesetzt und zur Hauptseite weitergeleitet

	$stmt = $pdo->prepare("SELECT *  FROM login WHERE benutzername = :benutzername");

		if ($stmt->execute(array(':benutzername' => $benutzername))) {
			if ($row = $stmt->fetch()) {
				$passwortdatenbank = $row["passwort"];
				password_verify ($passwort, $passwortdatenbank);

				if (password_verify ($passwort, $passwortdatenbank)) {
				$_SESSION["login-id"] = $row["login_id"];
				header('Location: posten3.php');
			}else {
                    echo '<p id="meldung">Deine eingegebenen Daten sind leider falsch. Probiers nochmal. Oder <a href="registrieren.php">registriere dich zuerst.</a></p><br>';
                }
		    }
		}
?>