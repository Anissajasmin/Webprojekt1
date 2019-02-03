<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suche</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="touch.css">

    <?php
    session_start();
    include_once "logincheck.php";
    if (!isset($_SESSION['login-id'])) {
        echo "Aktiviere zuerst deinen Account mittels der Email, die wir dir geschickt haben oder registriere dich zuerst. <a href=\"Startseite.php\">Zur Startseite</a>";
    }else{
    include("datenbankpasswort.php");
    include("header.php");

    $my_id = $_SESSION['login-id'];
    $user_id = $_GET['user_id'];

    //Profildaten der unterschiedlichen Nutzer
    $visit_user = $pdo->prepare("SELECT * FROM login WHERE login_id=$user_id");
    $visit_user->execute();
    $title = $visit_user->fetch();
    ?>
</head>

<body>
<div id="hauptseite">
    <div id="main">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div id="recommendation">
                        <h2 class="ueberschriftenmain"> Deine Vorschläge </h2>
                        <br>
                        <br>
                        <?php include_once"recommendation.php" ?>
                        <br>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div id="background">
                        <div id="ueberschriftmeinefreunde"> Dein Suchergebnis</div>
                        <br>
                        <br>
                        <?php
                        //Suchfunktion - Ergebnisse der Suche
                        if (isset($_POST["suche"])) {
                            $allebenutzername = $_POST["suchen"];

                            $benutzersuche = $pdo->prepare("SELECT * FROM profilbildlogin WHERE benutzername ='$allebenutzername' AND aktiviert = 1");
                            if ($benutzersuche->execute()) {
                                while ($row = $benutzersuche->fetch()) {
                                    $userid = $row['login_id'];
                                    echo "<div id=\"tabelleposts\">";
                                    ?>
                                    <div id="kasten">
                                        <a class="" href="profilseite.php?user_id=<?php echo $userid ?>"><img id="recommendationprofilbild" src="<?php echo $row['profilbildtext'] ?>"></a>
                                        <a class="" href="profilseite.php?user_id=<?php echo $userid ?>"><div id="kastentext"><?php echo $row['benutzername'] ?></div></a>
                                    </div>

                                    <?php
                                    echo "</div>";
                                         }
                                     } else {
                                     echo "<div id=\"tabelleposts\">";
                                     ?>
                        <div id="kasten">
                                <p> "No user found" </p>
                        </div>
                                <?php
                                echo "</div>";
                                     }
                                 }
                                 ?>
                        <br>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div id="profile">
                        <h2 class="ueberschriftenmain"> Profil
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
