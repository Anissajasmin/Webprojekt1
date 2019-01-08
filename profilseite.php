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

    session_start();
    include_once "logincheck.php";
            if (!isset($_SESSION['login-id'])) {
                 echo "Bitte logge dich ein oder registriere dich zuerst. <a href=\"Startseite.php\">Zur Startseite</a>";
            }else{
                include ("datenbankpasswort.php");
?>

<body>
    <div id="main">

        <div id="recommendation">
            <h2 class="ueberschriftenmain"> Recommendations
            </h2>
        </div>



        <div id="background">
<a style="..." href="">
    <div class="button9">
    <div>
        <?php
        //Profilbild soll hier angezeigt werden

        $stmt = $pdo->prepare("SELECT * FROM profilbildlogin WHERE user_id = $user_id ");

        $result = $stmt->execute();
        while ($row = $stmt->fetch()) {
            echo "<div id=\"button9\">";
            echo "<img src='" . $row['profilbildtext'] . "'height='120' 'weight: 120'>";
            echo "</div>";
        }

        ?>
    </div>
    </div>
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

            <a style="" href="settings.php?user_id=<?php echo $user_id; ?>">
                <?php
                if ($my_id == $user_id) {

                    ?>
                    <div class="button2">Settings</div>
                    <?php
                }
                ?>
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
        $posts = $pdo->prepare("SELECT * FROM beitrag WHERE user_id = :user_id AND posts IS NOT NULL OR user_id = :user_id AND bildtext IS NOT NULL ORDER BY zeitstempel DESC");
        $postsergebnis= $posts->execute(array(':user_id' => $user_id));
        if ($postsergebnis) {
        while ($row = $posts->fetch()) {
        ?>
            <div id="postsdernutzer">
                <small><?php echo $row['posts']?></small><br>
                <small><?php echo "<img src='" .$row['bildtext']. "'height='200'>";?></small><br>
            </div>


            <?php
        }

        }
        ?>





    </div>



        <div id="profile">
            <h2 class="ueberschriftenmain"> Profile
            </h2>

            <div id="tabellename1">
                <?php
                echo $title['benutzername'];
                ?>
            </div>

            <div id="tabelleemail1">
                <?php
                echo $title['hdm_mail'];
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

