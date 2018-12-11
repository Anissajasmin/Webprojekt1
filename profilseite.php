<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profilseite</title>
    <link rel="stylesheet" type="text/css" href="profilseite.css">
    <meta name = "viewport" content="width-device-width, initial-scale=1.0, maximum-scale=1.0, user scalelable=no">
</head>
<?php
include "includedesign.php";
?>

<?php
session_start();
include_once "logincheck.php";
if (!isset($_SESSION['login-id'])) {
    echo "Bitte logge dich ein oder registriere dich zuerst. <a href=\"Startseite.php\">Zur Startseite</a>";
}else{
?>
<body>

     <div class="header1"
        </div>
      <div class="coverpad">
      </div>



    <div id="main">

        <div id="recommondation">
            <h2 class="ueberschriftenmain"> Recommondations
            </h2>
        </div>
        <a style="..." href="">
            <div class="button8">Touches</div>
        </a>
    </div>



<div id="background">

    <a style="..." href="">
        <div class="button1">Save</div>
    </a>

    <a style="..." href="">
        <div class="button2">Settings</div>
    </a>


        <div class="button3">Friends</div>



        <div class="button4">Posts</div>



        <div class="button5">Touches</div>


    <div class="button6">Your Name</div>
    <div class="button7">Your E-Mail</div>


    <a style="..." href="">
        <div class="button9">Upload picture</div>
    </a>


    <div class = "button10"></div>
    <div id="ueberschrift">
        <h3> Your Profile</h3>
    </div>


    <form id=postbox2 action="login.php" method="post">
        <textarea id="text" name="text" placeholder="Write something..." cols="40" rows="4">
        </textarea>
        <br>
        <input type="submit">
    </form>




</body>
    <?php
}
?>
</html>
