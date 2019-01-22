<!<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profilseite</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="hauptseite.css">
</head>

<?php
session_start();
include_once "logincheck.php";
if (!isset($_SESSION['login-id'])) {
    echo "Bitte logge dich ein oder registriere dich zuerst. <a href=\"Startseite.php\">Zur Startseite</a>";
}else {
include("datenbankpasswort.php");
include_once "header.php";
include "follow.php";

$my_id = $_SESSION['login-id'];
$user_id = $_GET['user_id'];
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
                        $showallusers = $pdo->prepare ("SELECT * FROM login WHERE NOT login_id = $my_id");
                        $showallusers->execute();
                        while ($row1 = $showallusers->fetch()){
                            $allusers = $row1['login_id'];
                            echo "<div id=\"tabelleposts\">";
                            echo "<span>";
                            ?>
                            <div id="kasten">
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
                        $show_users = $pdo->prepare("SELECT * FROM login WHERE NOT login_id = $my_id AND NOT login_id = $userid");
                        $show_users->execute();

                        while($row3 = $show_users->fetch()) {
                            $users = $row3['login_id'];
                            echo "<div id=\"tabelleposts\">";
                            echo "<span>";
                            ?>
                            <div id="kasten">
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
                    <div id="ueberschrift">
                        Mein Profil
                    </div>


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

                    <?php // Profilangaben

                    // Daten des Nutzers anzeigen

        $statement = $pdo->prepare("SELECT * FROM benutzerdaten WHERE my_id= $my_id");
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
                        <td class="benennung">Semester: <?php echo $row8['semester']; ?></td>

                    </tr>

                </table>
                <?php
            }} else { ?>
            <p class="benennung"> Lege deine Benutzerdaten in deinen Einstellungen an!</p>
            <?php
        }

 ?>
<br>

                    <a style="" href="settings.php?user_id=<?php echo $user_id; ?>">
                        <?php
                        if ($my_id == $user_id) {

                            ?>
                            <div class="neubuttonsettings">Settings</div>
                            <?php
                        }
                        ?>
                    </a>

                    <br>

                    <hr class="strich3">

                    <div>

                        <?php


                        //Posts des Nutzers der Profilseite anzeigen
                        $statement = $pdo->prepare("SELECT * FROM vlj_beitraglogin WHERE beitrag_user_id = $my_id AND posts IS NOT NULL OR beitrag_user_id = $my_id AND bildtext IS NOT NULL ORDER BY zeitstempel DESC");
                        $postsergebnis = $statement->execute();
                        while ($row = $statement->fetch()) {
                            $userid = $row['login_id'];
                            ?>
                        <div id="tabelleposts">
                            <?php

                            $show_profilepic = $pdo->prepare("SELECT * FROM profilbildlogin WHERE login_id = $userid");
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
                    <h3 class="ueberschrift2"> Anzahl deiner Beiträge:
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