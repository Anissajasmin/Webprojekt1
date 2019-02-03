<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meine Freunde</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="touch.css">

    <?php
    session_start();
    if (!isset($_SESSION['login-id'])) {
        echo "Aktiviere zuerst deinen Account mittels der Email, die wir dir geschickt haben oder registriere dich zuerst. <a href=\"Startseite.php\">Zur Startseite</a>";
    }else{
    include("datenbankpasswort.php");
    include("header.php");
    ?>
</head>

<body>
<div id="hauptseite">
    <div id="main">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div id="recommendation">
                        <h2 class="ueberschriftenmain"> Recommendations
                        </h2>
                        <br>
                        <br>
                        <?php include_once"recommendation.php" ?>
                        <br>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div id="background">
                        <div id="ueberschriftmeinefreunde"> Meine Freunde</div>
                        <br>
                        <br>
                        <?php
                        //Liste mit den Namen der Personen, denen man folgt
                        //Es wird zuerst geschaut, ob man jemandem folgt

                        $checkfollow=$pdo->prepare("SELECT * FROM follow WHERE follow_id=$my_id");
                        $checkfollow->execute();
                        $nofollower=$checkfollow->rowCount();
                        if(!$nofollower > 0) {
                            //Wenn man niemandem folgt
                            echo "<div id=\"tabelleposts\">";
                            ?>
                            <div class="keinefreunde">
                            <?php
                            echo "Du hast noch keine Freunde. Folge einem Nutzer, um ihn in deiner Liste angezeigt zu bekommen!";?>
                            </div>
                            <?php
                            echo "</div>";
                        } else {
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
                                    <a href="profilseite.php?user_id=<?php echo $userid ?>"><img id="recommendationprofilbild" src="<?php echo $row4['profilbildtext'] ?>"></a>
                                    <a style="text-decoration:none;" href="profilseite.php?user_id=<?php echo $userid ?>"><div id="kastentext"><?php echo $row3['benutzername'] ?></div></a>
                                </div>
                                <?php
                                echo "</span>";
                                echo "</div>";
                            }
                        }
                        ?>
                        <br>
                    </div>
                </div>


                <div class="col-sm-3">
                    <div id="profile">
                        <h2 class="ueberschriftenmain"> Profile </h2>
                        <div class="name">
                            Benutzername:
                            <?php
                            echo $title['benutzername'];
                            ?>
                        </div>
                        <br>
                        <br>
                        <div class= "adresseneu">
                            E-Mail Adresse:
                            <br>
                            <?php
                            echo $title['hdm_mail'];
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

<br>
<br>

<?php
}
?>