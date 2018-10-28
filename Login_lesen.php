<?php
session_start();
$pdo = new PDO('mysql:: host=mars.iuk.hdm-stuttgart.de;dbname=u-nk093', 'nk093', 'oHae6Johxa', array('charset'=>'utf8'));

if(isset($_GET['login'])) {
    $email = $_POST['hdm_mail'];
    $passwort = $_POST['passwort'];

    $statement = $pdo->prepare("SELECT * FROM login WHERE hdm_mail = :hdm_mail");
    $result = $statement->execute(array('hdm_mail' => $email));
    $user = $statement->fetch();

    //Überprüfung des Passworts
    if ($user !== false && password_verify($passwort, $user['passwort'])) {
        $_SESSION['benutzername'] = $user['id_login'];
        die('Login erfolgreich. Weiter zu <a href="geheim.php">internen Bereich</a>');
    } else {
        $errorMessage = "E-Mail oder Passwort war ungültig<br>";
    }

}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

<?php
if(isset($errorMessage)) {
    echo $errorMessage;
}
?>

<form action="?login=1" method="post">
    E-Mail:<br>
    <input type="hdm_mail" size="40" maxlength="250" name="hdm_mail"><br><br>

    Dein Passwort:<br>
    <input type="password" size="40"  maxlength="250" name="passwort"><br>

    <input type="submit" value="Abschicken">
</form>
</body>
</html>