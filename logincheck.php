
<?PHP

	session_start();
    include ("datenbankpasswort.php");
if ( isset( $_POST["benutzername"] ) AND isset( $_POST["passwort"] ) ) {
    $benutzername = $_POST["benutzername"];
    $passwort = $_POST["passwort"];
    $passworthash = $passworthash = password_hash($passwort, PASSWORD_DEFAULT);
}
//Es werden Benutzername und Passwort überprüft und bei richtiger Eingabe, eine Session gesetzt und zur Hauptseite weitergeleitet

	$stmt = $pdo->prepare( "SELECT login_id, passwort  FROM login WHERE benutzername=:benutzername" );


		if ( $stmt->execute( array( ':benutzername' => $benutzername ) ) ) {
			if ( $row = $stmt->fetch() ) {
				$passwortdatenbank = $row['passwort'];

				if ( password_verify ($passwort, $passwortdatenbank)) {
				$_SESSION["logged-in"] = 1;
				$_SESSION["login-id"] = $row[":login_id"];
				header( 'Location: hauptseite.php' );
			} else {
				echo '<p id="meldung">Deine eingegebenen Daten sind leider falsch. Probiers nochmal. <a href="login.php">Zum Login</a></p><br>';
			}
		}
		}