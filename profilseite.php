<!DOCTYPE html>
<html lang="de">
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
    include ("datenbankpasswort.php");
?>

<?php
$my_id = $_SESSION['login-id'];
$user_id= $_GET['user_id'];


//Profildaten der unterschiedlichen Nutzer
$visit_user = $pdo ->prepare ("SELECT * FROM login WHERE login_id=$user_id");
$visit_user ->execute();
$title = $visit_user ->fetch();
?>




<body>
    <div id="main">

        <div id="recommendation">
            <h2 class="ueberschriftenmain"> Recommendations
            </h2>
        </div>

        <a style="..." href="">
            <div class="button8">Touches</div>
        </a>




            <div id="background">

                <a style="..." href="">
                    <div class="button9">Bild was hochgeladen wurde, soll hier angezeigt werden</div>
                </a>

                <div id="tabellename">
                    <?php
                    echo $title['benutzername'];
                    ?>
                </div>

                <div id="tabelleemail">
                    <?php
                    echo $title['hdm_mail'];
                    ?>

                </div>


                <a style="..." href="">
                 <div class="button2">Settings</div>
                </a>


        <div class="button3">Friends</div>



        <div class="button4">Posts</div>


                <br>
                <hr class="strich">






    <br>
    <hr class="strich">


    <div class = "button10"></div>
    <div id="ueberschrift">
        <h3> Your Profile</h3>
    </div>



                <?php
                //Posts des Nutzers der Profilseite anzeigen
                $posts = $pdo->prepare("SELECT * FROM beitrag WHERE user_id= $user_id  ORDER BY zeitstempel DESC");
                $postsergebnis= $posts->execute(array(':user_id' => $user_id));
                if ($postsergebnis) {
                    while ($row = $posts->fetch()) {
                        ?>

                        <div id="postsdernutzer">
                            <small><?php echo $row['posts']?></small><br>
                            <small><?php echo $row['bildtext']?></small><br>
                        </div>



                        <?php
                    }

                }
                ?>


    </div>
</div>
</body>
</html>
    <?php
}
?>

<?php
include_once "follow.php";
?>

