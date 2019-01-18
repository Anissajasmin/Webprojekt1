<?php
include_once "header.php";
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Meine Freunde</title>
    <link rel="stylesheet" type="text/css" href="meinefreunde.css">
    <link rel="stylesheet" type="text/css" href="profilseite.css">
    <meta name = "viewport" content="width-device-width, initial-scale=1.0, maximum-scale=1.0, user scalelable=no">
</head>
<?php
session_start();
include_once "logincheck.php";
if (!isset($_SESSION['login-id'])) {
    echo "Bitte logge dich ein oder registriere dich zuerst. <a href=\"Startseite.php\">Zur Startseite</a>";
}else{
include ("datenbankpasswort.php");
include ("follow.php")

?>
<body>
<div id="main">

    <div id="recommendation">
        <h2 class="ueberschriftenmain"> Recommendations
        </h2>
    </div>



    <div id="background">
        <p id="meinefreunde"> Meine Freunde </p>

        <?php
        //Liste mit den Namen der Personen, denen man folgt
        //Es wird zuerst geschaut, ob man jemandem folgt

        $checkfollow=$pdo->prepare("SELECT * FROM follow WHERE follow_id=$my_id");
        $checkfollow->execute();
        $nofollower=$checkfollow->rowCount();
        if(!$nofollower > 0) {
            //Wenn man niemandem folgt
            echo "<div id=\"tabelleposts\">";
            echo "Du hast noch keine Freunde. Folge einem Nutzer, um ihn in deiner Liste angezeigt zu bekommen!";
            echo "</div>";
        }
        else {
            //Wenn man jemandem folgt, werden die Namen der Personen, denen man folgt, in dieser Liste angezeigt
            while($row = $checkfollow->fetch()) {
                $userid = $row['user_id'];
                $show_profilepic = $pdo->prepare ("SELECT * FROM profilbildlogin WHERE login_id = $userid");
                $show_profilepic->execute();
                $show_friends = $pdo->prepare("SELECT * FROM vlj_loginfollow WHERE login_id= $userid");
                $show_friends->execute();

               $row3 = $show_friends->fetch();
               $row4 = $show_profilepic->fetch();

                    echo "<div id=\"tabelleposts\">";
                    echo "<span>";
                    ?>
                    <div id="kasten">
                        <a href="profilseite.php?user_id=<?php echo $userid ?>"><img src="<?php echo $row4['profilbildtext'] ?>"></a>
                        <a style="text-decoration:none;" href="profilseite.php?user_id=<?php echo $userid ?>"><div id="kastentext"><?php echo $row3['benutzername'] ?></div></a>

                    </div>
                    <?php
                    echo "</span>";
                    echo "</div>";

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
</div>

</body>
</html>

<?php
}
?>