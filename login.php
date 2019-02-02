<!DOCTYPE html>
<html lang="de">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="touch.css">
    <link href="bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
          integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"
            integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
            integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
            crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>

<body>
<?php
session_start();
include_once "logincheck.php";
include("datenbankpasswort.php");
$my_id = $_SESSION['login-id'];
?>
<div class="container">
    <div class="row">
        <div class="col-xs-3">
        </div>
        <div class="col-xs-6"
        <div id="headerlogin">
            <h1 id="ueberschriftlogin"> TOUCH </h1>
        </div>
    </div>

    <div class ="col-xs-3"> </div>
</div>
</div>

<div class="container">
    <div class="row">
        <div class="col-xs-3">
        </div>
        <div class="col-xs-6"
        <div id="main2">
            <h1 id="unterueberschriftlogin"> Login </h1>
            <form action="hauptseite.php?user_id=<?php echo $my_id;?>" method="post">
                <p class="beschriftungbenutzername"> Benutzername: </p>
                <input class="beschriftung2" type="text" size="25" maxlength="250" name="benutzername" ><br><br>
                <p class="beschriftungpasswort"> Dein Passwort: </p>
                <input class="beschriftung2" type="password" size="25"  maxlength="250" name="passwort" ><br><br>
                <input id="loginbutton" type="submit" name="login" value="Get in touch">
            </form>

        </div>
    </div>

    <div class ="col-xs-3"> </div>
</div>
</div>


<?php
session_start();
include_once ("logincheck.php");
$user_id = $_SESSION["login-id"];
if (isset($_SESSION['login-id'])) {
    header("Location: hauptseite.php?user_id=$user_id");
}
?>
</body>
</html>