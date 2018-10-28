<?php
session_start();
$pdo = new PDO('mysql:: host=mars.iuk.hdm-stuttgart.de;dbname=u-nk093', 'nk093', 'oHae6Johxa'array('charset'=>'utf8'));
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registrierung</title>
</head>
<body>

<?php
$showFormular = true;

if(isset($_GET['register'])) {
    $error = false;
    $email = $_POST['hdm_mail'];
    $passwort = $_POST['passwort'];

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo 'Bitte deine Hdm-Mail-Adresse eingeben<br>';
        $error = true;
    }
    if(strlen($passwort) == 0) {
        echo 'Bitte ein sicheres Passwort angeben<br>';
        $error = true;
    }

    //Überprüfe, dass die E-Mail-Adresse noch nicht registriert wurde
    if(!$error) {
        $statement = $pdo->prepare("SELECT * FROM login WHERE hdm_mail = :hdm_mail");
        $result = $statement->execute(array('hdm_mail' => $email));
        $user = $statement->fetch();

        if($user !== false) {
            echo 'Diese E-Mail-Adresse ist bereits vergeben<br>';
            $error = true;
        }
    }

    //Keine Fehler, wir können den Nutzer registrieren
    if(!$error) {
        $passwort_hash = password_hash($passwort, PASSWORD_DEFAULT);

        $statement = $pdo->prepare("INSERT INTO login (hdm_mail, passwort) VALUES (:hdm_mail, :passwort)");
        $result = $statement->execute(array('hdm_mail' => $email, 'passwort' => $passwort_hash));

        if($result) {
            echo 'Du wurdest erfolgreich registriert. <a href="login_lesen.php">Zum Login</a>';
            $showFormular = false;
        } else {
            echo 'Beim Abspeichern ist leider ein Fehler aufgetreten<br>';
        }
    }
}

if($showFormular) {
    ?>

    <form action="?register=1" method="post">
        HdM E-Mail:<br>
        <input type="hdm_mail" size="40" maxlength="250" name="hdm_mail"><br><br>

        Dein Passwort:<br>
        <input type="password" size="40"  maxlength="250" name="passwort"><br>


        <input type="submit" value="Abschicken">
    </form>

    <?php
} //Ende von if($showFormular)
?>

</body>
</html>