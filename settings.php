
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
include "checkbox.php";
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

        <div id="recommondation">
            <h2 class="ueberschriftenmain"> Recommondations
            </h2>
        </div>




        <div id="background">

            <a style="..." href="">
                <div class="button1">Save</div>
            </a>



            <div id="ueberschrift">
                <h2 class="ueberschriftenmain1"> Settings
                </h2>
            </div>

            <div class = "center">
                <input type = "checkbox">

                <a style="..." href="">
                    <div class="button9">Upload picture</div>
                </a>


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
                <div id = "center">
                </div>

                <div id = "checkbox1">
                </div>



        </div>

    </body>

    <?php
}
?>
</html>