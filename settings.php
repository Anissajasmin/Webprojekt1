
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profilseite</title>
    <link rel="stylesheet" type="text/css" href="settings.css">
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


    <div id="settings">

        <div class id="header">
            <h1>TOUCH </h1>

            <div id = "searcharea" class ="header"><input placeholder= "Search here..." type="text" id="searchbox"/></div>
            <a style="text-decoration:none;" href="">
                <div id="notificationneu"><img src="notificationneu.png"/><div>
            </a>


            <a style="text-decoration:none;" href="">
                <div id="messageneu"><img src="messageneu.png"/><div>
            </a>


            <a style="text-decoration:none;" href="">
                <div id="settingneu"><img src="settingneu.png"/><div>
            </a>


        </div>

        <div class="header1"
    </div>
    <div class="coverpad">
    </div>


    <div id="main">

        <div id="recommendation">
            <h2 class="ueberschriftenmain"> Recommendations
            </h2>
        </div>
    </div>




<div id="background">

            <a style="..." href="">
                <div class="button1">Save</div>
            </a>

    <br>
    <hr class="strich">

            <div class = "button10"></div>
            <div id="ueberschrift">
                <h3> Settings </h3>
            </div>


                <a style="..." href="">
                    <div class="button9">Upload picture</div>
                </a>

    <label class="switch">
        <input class="switch-input" type="checkbox" />
        <span class="switch-label" data-on="On" data-off="Off"></span>
        <span class="switch-handle"></span>
    </label>

        <div id="tabellename">


                    <?php
                    echo $_SESSION["username"];
                    ?>

                </div>


                <div id="tabelleemail">

                    <?php
                    echo $_SESSION["mail"];
                    ?>







        </div>

    </body>

    <?php
}
?>
