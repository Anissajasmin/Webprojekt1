<!DOCTYPE html>
<html lang="de">
<link rel="stylesheet" type="text/css" href="header.css">

<?php
session_start();
include_once "logincheck.php";
include("datenbankpasswort.php");

$my_id = $_SESSION['login-id'];
$meine_id = $_SESSION['login-id'];
$user_id = $_GET['user_id'];

//Profildaten der unterschiedlichen Nutzer
$visit_user = $pdo->prepare("SELECT * FROM login WHERE login_id=$user_id");
$visit_user->execute();
$title = $visit_user->fetch();

?>

<head>
    <meta charset="UTF-8">
    <title>Hauptseite</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="bootstrap.min.js"></script>
    <script src="jquery-3.2.1.slim.min.js"></script>
    <script src="bootstrap.min.js"></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
          integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
            integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"
            integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
            integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
            crossorigin="anonymous"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

</head>

<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a id="fonttouch" class="navbar-brand">TOUCH</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" id="fontfeed" href="hauptseite.php?user_id=<?php echo $my_id; ?>">Mein Feed
                    <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                   data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false"> Profil
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" id="fontprofil" href="profilseite.php?user_id=<?php echo $my_id; ?>">Mein Profil</a>
                    <a class="dropdown-item" id="fonteinstellungen"
                       href="settings.php?user_id=<?php echo $my_id; ?>"> Einstellungen
                    </a>
                </div>

            </li>
            <li class="nav-item active">
                <a class="nav-link" id="fontfreunde" href="meinefreunde.php?user_id=<?php echo $my_id; ?>">Meine Freunde <span class="sr-only">(current)</span></a>
            </li>
        </ul>
        <div>
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown">
                    <a class="btn btn-outline-dark"
                       style="font-family: 'Helvetica Neue'; font-size:120%; font-weight: 200;" href="#"
                       id="dropdown01" data-toggle="dropdown" aria-haspopup="true"
                       aria-expanded="false"> Benachrichtigungen

                        <?php
                        include_once "notification.php"
                        ?>

        </div>

        <form action="sucheergebnis.php?user_id=<?php echo $my_id ?>" class="form-inline my-2 my-lg-0 " method = "post">
            <input class="form-control mr-sm-2 "
                   style="font-family: 'Helvetica Neue'; font-size:120%; font-weight: 200;" name="suchen"
                   type="search" placeholder="Suchen" aria-label="Search">
            <button class="btn btn-outline-dark my-2 my-sm-0"
                    style="font-family: 'Helvetica Neue'; font-size:120%; font-weight: 200;" name="suche" id="suchebutton"
                    type="submit">Suche
            </button>
        </form>

        <button type="button" class="btn btn-outline-dark " style=" font-family: 'Helvetica Neue'; color:white; font-size:120%; font-weight: 200; background-color:#7B0202;"">
        <a style=color:white; href="logout.php">Log Out</a>
        </button>


</nav>
</div>

</body>
</html>