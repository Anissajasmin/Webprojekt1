
<?PHP

	session_start();
    include ("datenbankpasswort.php");
    $benutzername = $_POST["benutzername"];
    $passwort = $_POST["passwort"];

//Es werden Benutzername und Passwort überprüft und bei richtiger Eingabe, eine Session gesetzt und zur Hauptseite weitergeleitet

	$stmt = $pdo->prepare( "SELECT login_id, passwort  FROM login WHERE benutzername=:benutzername" );


		if ( $stmt->execute( array( ':benutzername' => $benutzername ) ) ) {
			if ( $row = $stmt->fetch() ) {
				$passwort = $row[":passwort"];

				if ( $passwort = $row[":passwort"]) {
				$_SESSION["logged-in"] = 1;
				$_SESSION["login-id"] = $row[":login_id"];
				header( 'Location: hauptseite.php' );
			} else {
				echo '<p id="meldung">Deine eingegebenen Daten sind leider falsch. Probiers nochmal. <a href="login.php">Zum Login</a></p><br>';
			}
		}
		}