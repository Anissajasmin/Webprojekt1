<!DOCTYPE html>

<html>
<head>

    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <link rel="stylesheet" type="text/css" href="Login_lesen.css">
</head>
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

            <input id="loginbutton" type="submit" value="Get in touch">
        </form>
    </div>


</body>
</html>



