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

?>


<body>
<div id="main">
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div id="recommendationsprofilseite">
                    <h2 class="ueberschriftenmain"> Recommendations
                    </h2>
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

                    <?php // Profilangaben
                    ?>

                    <table id="profildatenneu">

                        <tr>
                            <td class="benennung">Vorname:</td>
                        </tr>


                        <tr>
                            <td class="benennung">Nachname:</td>
                        </tr>

                        <tr>
                            <td class="benennung">Studiengang:</td>
                        </tr>

                        <tr>
                            <td class="benennung">Semester:</td>

                        </tr>

                    </table>


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
                        $posts = $pdo->prepare("SELECT * FROM vlj_beitraglogin WHERE beitrag_user_id = :beitrag_user_id AND posts IS NOT NULL OR beitrag_user_id = :beitrag_user_id AND bildtext IS NOT NULL ORDER BY zeitstempel DESC");
                        $postsergebnis = $posts->execute(array(':beitrag_user_id' => $user_id));
                        if ($postsergebnis) {
                        while ($row = $posts->fetch()) {
                            echo "<div id=\"tabelleposts\">";
                            $userid = $row['login_id'];
                            $show_profilepic = $pdo->prepare("SELECT * FROM profilbildlogin WHERE login_id = $userid");
                            $show_profilepic->execute();
                            $row4 = $show_profilepic->fetch(); ?>

                            <a><img id="postsprofilbild" src="<?php echo $row4['profilbildtext'] ?>"></a>
                            <a id="postsbenutzername"><?php echo $row['benutzername'] ?> </a>
                            <div id="postszeit"> <?php echo $row['zeitstempel'] ?> </div>
                            <div id="poststext"> <?php echo $row['posts'] ?></div>
                            <?php echo "<img src='" . $row['bildtext'] . "' height='150'>";
                            echo "</div>";
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
}
?>