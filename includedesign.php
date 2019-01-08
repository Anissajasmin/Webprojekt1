<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hauptseite</title>
    <link rel="stylesheet" type="text/css" href="includedesign.css">

<?php
session_start();
include_once "logincheck.php";
if (!isset($_SESSION['login-id'])) {
    echo "Bitte logge dich ein oder registriere dich zuerst. <a href=\"Startseite.php\">Zur Startseite</a>";
}else {
    include("datenbankpasswort.php");
}
$my_id = $_SESSION['login-id'];
$user_id= $_GET['user_id'];


//Profildaten der unterschiedlichen Nutzer
$visit_user = $pdo ->prepare ("SELECT * FROM login WHERE login_id=$user_id");
$visit_user ->execute();
$title = $visit_user ->fetch();

?>

</head>

<body>

<div id="hauptseite">


    <div id="header">
        <h1>TOUCH</h1>
        <form action="" id = "searcharea" class ="header" method="post">
            <input placeholder= "Search here..." type="text" name="suche" id="searchbox"/>
            <input type="hidden" name="suchegesendet" value="1">
            <input id="suchebutton" type="submit" value="Suchen">
        </form>
        <?php
        //Suchfunktion

        if (isset($_POST["suche"])) {
            $allebenutzername = $_POST["suche"];

            $benutzersuche = $pdo->prepare("SELECT * FROM vlj_loginprofilbild WHERE benutzername = '$allebenutzername' AND aktiviert = 1");
            if ($benutzersuche->execute()) {

                while ($row = $benutzersuche->fetch()) {
                    $userid = $row ['login_id'];
                    ?>
                    <h3>
                        <a href="profilseite.php?user_id=<?php echo $userid ?>"><img src="<?php echo $row['profilbildtext'] ?>"></a>
                        <a href="profilseite.php?user_id=<?php echo $userid ?>"><?php echo $row['benutzername'] ?></a>
                    </h3>

                    <?php
                }
            } else {
                echo "<div>No user found</div>";
            }
        }
        ?>
        <div id="logoutbutton"> <a href="logout.php">Log Out</a></div>
        <ul id="navigation">

            <li class="listitem"><a href="hauptseite.php?user_id=<?php echo $user_id; ?>">Mein Feed</a></li>
            <li class="listitem"><a href="profilseite.php?user_id=<?php echo $user_id; ?>">Mein Profil</a>
                <ul>
                    <li><a href="#"> Meine Daten</a></li>
                    <li><a href="#"> Meine Beiträge</a></li>
                    <li><a href="settings.php?user_id=<?php echo $user_id; ?>"> Einstellungen</a></li>
                </ul>
            </li>
            <li class="listitem"><a href="meinefreunde.php?user_id=<?php echo $user_id; ?>">Meine Freunde</a></li>

        </ul>





    </div>




</div>

</body>
</html>

