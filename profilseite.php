<!<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profilseite</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="touch.css">
</head>

<?php
session_start();
include_once "logincheck.php";
if (!isset($_SESSION['login-id'])) {
    echo "Bitte logge dich ein oder registriere dich zuerst. <a href=\"Startseite.php\">Zur Startseite</a>";
}else {
include("datenbankpasswort.php");
include_once "header.php";

?>


<body>
<div id="main">
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div id="recommendationsprofilseite">
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
                <div id="backgroundprofilseite">

                    <?php

                    if($user_id==$my_id) {
                        ?>
                    <div id="ueberschrift">
                        Mein Profil
                    </div>
                    <?php
                    } else {?>
                        <div id="ueberschrift">
                        Benutzerprofil
                        </div>
                        <?php
                    }
                    ?>



                    <div>

                        <?php
                        //Profilbild soll hier angezeigt werden

                        $stmt = $pdo->prepare("SELECT * FROM profilbildlogin WHERE profil_user_id = $user_id ");

                        $result = $stmt->execute();
                        while ($row = $stmt->fetch()) {
                            ?>
                            <a><img id="profilbild1" src="<?php echo $row['profilbildtext'] ?>"></a>
                            <?php
                        }

                        ?>
                    </div>

                    <div id="benutzernameprofil">
                        <?php
                        echo $title['benutzername'];
                        ?>
                    </div>

                    <div id="benutzernamemail">

                        <?php
                        echo $title['hdm_mail'];
                        ?>

                    </div>
                    <br>
<?php
$follow_id = $_SESSION['login-id'];
// Ist es ein fremdes Profil?
if ($user_id != $_SESSION['login-id']) {

    // Wird dem Benutzer bereits gefolgt?
    $checkfollow = $pdo->prepare("SELECT follow_id FROM follow WHERE user_id='" . $user_id . "' AND follow_id='" . $follow_id . "'");
    $checkfollow->execute();

    $notfollowing = $checkfollow->rowCount();

    if (!$notfollowing > 0) {
        ?>
        <form action="profilseite.php?user_id=<?php echo $user_id ?>" method="post">
            <input class="followbutton" type="submit" name="follow" value="Folgen">

        </form>

        <?php

        if (isset($_POST["follow"])) {
            $follow = $pdo->prepare('INSERT INTO follow (follow_id, user_id) VALUES (:follow_id, :user_id)');
            $follow->bindParam(':follow_id,', $follow_id);
            $follow->bindParam(':user_id,', $user_id);
            $followergebnis = $follow->execute(array(':follow_id' => $follow_id, ':user_id' => $user_id));

            if ($followergebnis) {

                echo '<script>window.location.href="profilseite.php?user_id=' . $user_id . '"</script>';
            }
        }


    }

    else {
        //Unfollow
        ?>

        <form action="profilseite.php?user_id=<?php echo $user_id?>" method="post">
            <input class="followbutton" type="submit" name="unfollow" value="Entfolgen">
        </form>

        <?php
        if (isset($_POST['unfollow'])) {
            $unfollow = $pdo -> prepare("DELETE FROM follow WHERE user_id='" . $user_id . "' AND follow_id='" . $follow_id . "'");
            if ($unfollow->execute()) {
                echo '<script>window.location.href="profilseite.php?user_id='.$user_id.'"</script>';
            }

        }


    }



}

?>

                    <br>
                    <hr class="strich4">

                    <?php // Profilangaben
                    // Daten des Nutzers anzeigen
                    $statement = $pdo->prepare("SELECT * FROM benutzerdaten WHERE my_id= $user_id");
                    $statement->execute();
                    $benutzerdaten = $statement->rowCount();
                    if ($benutzerdaten) {
                        while ($row8 = $statement->fetch()) {
                            ?>



                            <table id="profildatenneu">

                                <tr>
                                    <td class="benennung">Vorname: <?php echo $row8['vorname']; ?></td>
                                </tr>


                                <tr>
                                    <td class="benennung">Nachname: <?php echo $row8['nachname']; ?></td>
                                </tr>

                                <tr>
                                    <td class="benennung">Studiengang: <?php echo $row8['studiengang']; ?></td>
                                </tr>

                                <tr>
                                    <td class="benennung">Semester: <?php echo $row8['semester']; ?> </td>

                                </tr>

                            </table>
                            <?php
                        }} elseif($my_id == $user_id) { ?>

                        <p class="benennung4"> Lege deine Benutzerdaten in deinen Einstellungen an!</p>

                        <?php
                    } elseif($my_id != $user_id) { ?>
                        <div id="profildatenneu">
                        <p class="benennung4"> Dieser Benutzer hat noch keine Daten angelegt!</p>
                        </div>
                        <?php
                    }
                    ?>

                    <?php
                    if($user_id != $my_id) {
                        ?>

                        <p id="ueberschriftneuneufreunde"> Anzahl Freunde
                        <div id="buttonfriendsneuneu">
                            <div class="anzahlneuneu">
                            <?php
                            $anzahlfriends = $pdo->prepare("SELECT ALL * FROM follow WHERE follow_id = $user_id ");
                            $anzahlfriends->execute();
                            $showanzahlfriends = $anzahlfriends->rowCount();
                            echo $showanzahlfriends;
                            ?>
                            </div>
                            </div>
                        </p>

                          <p id="ueberschriftneuneubeiträge"> Anzahl Beiträge
                        <div id="buttonbeiträgeneuneu">
                            <div class="anzahlneuneu">
                            <?php
                            $anzahlposts = $pdo->prepare("SELECT ALL * FROM beitrag WHERE beitrag_user_id = $user_id ");
                            $anzahlposts->execute();
                            $showanzahlposts = $anzahlposts->rowCount();
                            echo $showanzahlposts;
                            ?>
                            </div>
                        </div>
                        </p>

                        <?php
                    }
                            ?>
                    <br>
                    <br>



                    <a style="" href="settings.php?user_id=<?php echo $user_id; ?>">
                        <?php
                        if ($my_id == $user_id) {

                            ?>

                            <div class="neubuttonsettings">Einstellungen</div>

                            <?php
                        }
                        ?>
                    </a>

                    <br>

                    <hr class="strich3">

                    <div>

                        <?php
                        //Posts des Nutzers der Profilseite anzeigen
                        $statement = $pdo->prepare("SELECT * FROM vlj_beitraglogin WHERE beitrag_user_id = $user_id AND posts IS NOT NULL OR beitrag_user_id = $user_id AND bildtext IS NOT NULL ORDER BY zeitstempel DESC");
                        $postsergebnis = $statement->execute();
                        while ($row = $statement->fetch()) {
                            $userid = $row['login_id'];
                            ?>
                            <div id="tabelleposts">
                                <?php
                                $show_profilepic = $pdo->prepare("SELECT * FROM profilbildlogin WHERE login_id = $user_id");
                                $show_profilepic->execute();
                                $row4 = $show_profilepic->fetch();
                                ?>
                                <a><img id="postsprofilbild" src="<?php echo $row4['profilbildtext'] ?>"></a>
                                <a id="postsbenutzername"><?php echo $row['benutzername'] ?> </a>
                                <?php echo "</span>"; ?>
                                <div id="postszeit"> <?php echo $row['zeitstempel'] ?> </div>
                                <?php echo "</span>"; ?>
                                <div id="poststext"> <?php echo $row['posts'] ?></div>
                                <?php echo "</span>"; ?>

                                <img id="postsbild" src="<?php echo $row['bildtext'] ?>">

                            </div>
                            <?php
                        }
                        ?>
<br>

                    </div>
                </div>
            </div>


            <div class="col-sm-3">
                <div id="anzeigederbeiträgeundfreunde">
                    <h2 class="ueberschrift1"> Anzahl deiner Freunde:
                        <h2 id="buttonfriendsneu">
                            <div class="anzahl">
                            <?php
                            $anzahlfriends = $pdo->prepare("SELECT ALL * FROM follow WHERE follow_id = $my_id ");
                            $anzahlfriends->execute();
                            $showanzahlfriends= $anzahlfriends->rowCount();
                            echo $showanzahlfriends;
                            ?>
                            </div>
                        </h2>
                    </h2>
                    <h3 class="ueberschrift21"> Anzahl deiner Beiträge:
                        <h2 id="buttonpostsneu">
                            <div class="anzahl">
                            <?php
                            $anzahlposts = $pdo->prepare("SELECT ALL * FROM beitrag WHERE beitrag_user_id = $my_id ");
                            $anzahlposts->execute();
                            $showanzahlposts= $anzahlposts->rowCount();
                            echo $showanzahlposts;
                            ?>
                            </div>
                        </h2>
                    </h3>

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