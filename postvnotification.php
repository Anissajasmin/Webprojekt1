<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Benachrichtigung</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="touch.css">

    <?php
    session_start();
    if (!isset($_SESSION['login-id'])) {
        echo ">Zur Startseite</a>";
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
                        <?php
                        //Nutzer, denen man noch nicht folgt werden hier angezeigt
                        //Wird dem Benutzer bereits gefolgt?
                        $checkfollow = $pdo->prepare("SELECT * FROM follow WHERE follow_id='" . $my_id . "'");
                        $checkfollow->execute();
                        $notfollowing = $checkfollow->rowCount();
                        if (!$notfollowing > 0) {
                            $showallusers = $pdo->prepare ("SELECT * FROM profilbildlogin WHERE NOT login_id = $my_id");
                            $showallusers->execute();
                            while ($row1 = $showallusers->fetch()){
                                $allusers = $row1['login_id'];
                                echo "<div id=\"tabelleposts\">";
                                echo "<span>";
                                ?>
                                <div id="kasten">
                                    <a href="profilseite.php?user_id=<?php echo $allusers ?>"><img id="recommendationprofilbild" src="<?php echo $row1['profilbildtext'] ?>"></a>
                                    <a style="text-decoration:none;" href="profilseite.php?user_id=<?php echo $allusers ?>"><div id="kastentext"><?php echo $row1['benutzername'] ?></div></a>
                                </div>
                                <?php
                                echo "</span>";
                                echo "</div>";
                            }
                        }else{
                            $row = $checkfollow->fetch();
                            $userid = $row['user_id'];
                            $my_id = $row ['follow_id'];
                            //Wenn man jemandem nicht folgt, werden die Namen der Personen, denen man nicht folgt, in dieser Liste angezeigt
                            $show_users = $pdo->prepare("SELECT * FROM profilbildlogin WHERE NOT login_id = $my_id AND NOT login_id = $userid");
                            $show_users->execute();
                            while($row3 = $show_users->fetch()) {
                                $users = $row3['login_id'];
                                echo "<div id=\"tabelleposts\">";
                                echo "<span>";
                                ?>
                                <div id="kasten">
                                    <a href="profilseite.php?user_id=<?php echo $users ?>"><img id="recommendationprofilbild" src="<?php echo $row3['profilbildtext'] ?>"></a>
                                    <a style="text-decoration:none;" href="profilseite.php?user_id=<?php echo $users ?>"><div id="kastentext"><?php echo $row3['benutzername'] ?></div></a>

                                </div>
                                <?php
                                echo "</span>";
                                echo "</div>";
                            }
                        }
                        ?>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div id="background">
                        <?php

                        $user_id = $_GET['user_id'];
                        $n_id = $_GET['n_id'];
                        $status1 = 'unread';
                        $status = 'read';

                        $searchnotification = $pdo->prepare("SELECT * FROM notification WHERE notification_id ='" . $n_id . "' AND status='" . $status1 . "'");
                        $match = $searchnotification->execute();
                        if ($match > 0) {


                            $updatenotification = $pdo->prepare("UPDATE notification SET status = 'read' WHERE notification_id= '" .$n_id . "'");
                            $updatenotification->bindParam(':notification_id', $n_id);
                            $updatenotification->execute();

                            $notification = $pdo->prepare("SELECT * FROM vlj_notification WHERE notification_id = $n_id");
                            $notification->execute();
                            while ($row = $notification->fetch()) {

                                $post = $row['posts'];
                                $postbild = $row ['bildtext'];
                                $benutzername = $row['benutzername'];
                                ?>




                                <p id="postnotname">  <?php echo $benutzername;
                                    echo '&nbsp';
                                    echo "hat etwas Neues gepostet:"; ?>
                                </p>
                                <?php echo '&nbsp'; ?>
                                <div id="postnotkasten2">
                                    <p id="postnotpost">  <?php echo $post; ?>
                                        <?php echo "<img id= postnotpostbild src='" . $postbild . "'>"; ?>
                                    </p>
                                </div>
                                <a style="text-decoration:none; color:white;" href="hauptseite.php?user_id=<?php echo $user_id; ?>">
                                    <div id="postnotbutton">Zurück zum Feed

                                    </div>
                                </a>
                                <?php
                            }
                        }
                        ?>
                        <br>
                        <br>
                        <br>


                    </div>
                </div>


                <div class="col-sm-3">
                    <div id="profile">
                        <h2 class="ueberschriftenmain"> Profile
                        </h2>

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
