<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="login.css">
</head>
<body>

<body>
<div id="startseite">
    <div id="header">
        <h1 id="ueberschrift"> TOUCH </h1>

    </div>
    <div id="main">
        <h2 id="unterueberschrift"> Login
        </h2>



        <form action="?login=1" method="post">
            <p class="beschriftung"> Benutzername: </p>
            <input class="beschriftung2" type="text" size="25" maxlength="250" name="benutzername" ><br><br>

            <p class="beschriftung"> Dein Passwort: </p>
            <input class="beschriftung2" type="password" size="25"  maxlength="250" name="passwort" ><br><br>

            <input id="loginbutton" type="submit" name="login" value="Get in touch">
        </form>
    </div>

<?php
session_start();

include_once ("logincheck.php");
if (isset($_SESSION['logged-in'])) {

}else {
    echo '<p id="meldung">Deine eingegebenen Daten sind leider falsch. Probiers nochmal.
<a href="login.php">Zum Login</a></p><br>';
}


?>
</body>
</html>