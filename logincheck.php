
<?php

session_start();

include ("datenbankpasswort.php");
if (isset($_POST["benutzername"]) AND isset($_POST["passwort"])) {
    $benutzername = $_POST["benutzername"];
    $passwort = $_POST["passwort"];
    $passworthash = password_hash($passwort, PASSWORD_DEFAULT);

}

//Es wird zuerst geschaut, ob die Aktivierungsmail bestätigt wurde, dann werden Benutzername und
//Passwort überprüft und bei richtiger Eingabe, eine Session gesetzt und zur Hauptseite weitergeleitet

$stmt = $pdo->prepare("SELECT * FROM login WHERE benutzername='" . $benutzername . "' AND passwort='" . $passwort . "' AND aktiviert = 1");
$match = $stmt->execute();


if($match) {

    $stmt = $pdo->prepare("SELECT *  FROM login WHERE benutzername = :benutzername AND aktiviert = 1");

    if ($stmt->execute(array(':benutzername' => $benutzername))) {
        if ($row = $stmt->fetch()) {
            $user_id = $row['login_id'];
            $passwortdatenbank = $row["passwort"];
            password_verify($passwort, $passworthash);

            if (password_verify($passwort, $passworthash)) {

                $_SESSION["login-id"] = $row["login_id"];
                $_SESSION["username"] = $row ["benutzername"];
                $_SESSION["mail"] = $row ["hdm_mail"];

                }
                header("Location: hauptseite.php?user_id=$user_id");


            }
        }
    }

?>