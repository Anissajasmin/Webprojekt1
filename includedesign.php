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
        <div id="logoutbutton"> <a href="logout.php">Log Out</a></div>
        <ul id="navigation">

            <li class="listitem"><a href="hauptseite.php?user_id=<?php echo $user_id; ?>">Mein Feed</a></li>
            <li class="listitem"><a href="profilseite.php?user_id=<?php echo $user_id; ?>">Mein Profil</a>
                <ul>
                    <li><a href="#"> Meine Daten</a></li>
                    <li><a href="#"> Meine Beiträge</a></li>
                    <li><a href="#"> Einstellungen</a></li>
                </ul>
            </li>
            <li class="listitem"><a href="#">Meine Freunde</a></li>

        </ul>

        <div id = "searcharea" class ="header"><input placeholder= "Search here..." type="text" id="searchbox"/></div>

        <a style="text-decoration:none;" href="">
            <div id="notificationneu"><img src="notificationneu.png"/><div>
        </a>


        <a style="text-decoration:none;" href="">
            <div id="messageneu"><img src="messageneu.png"/><div>
        </a>


        <a style="text-decoration:none;" href="">
            <div id="settingneu"><img src="settingneu.png"/><div>
        </a>


    </div>




</div>

</body>
</html>

