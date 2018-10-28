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
    Benutzername:<br>
    <input type="text" size="40" maxlength="250" name="benutzername" placeholder="Benutzername"><br><br>

    Dein Passwort:<br>
    <input type="password" size="40"  maxlength="250" name="passwort" placeholder="Passwort"><br><br>

    <input type="submit" value="Login">
</form>
</body>
</html>

<?php
session_start();
$pdo = new PDO('mysql:host=mars.iuk.hdm-stuttgart.de;dbname=u-nk093', 'nk093', 'oHae6Johxa');

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
