<!DOCTYPE html>
<html lang="en">
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
    <a class="navbar-brand" href="#">TOUCH</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="hauptseite.php?user_id=<?php echo $user_id; ?>">Mein Feed <span
                        class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    Profil
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="profilseite.php?user_id=<?php echo $user_id; ?>">Mein Profil</a>
                    <a class="dropdown-item" href="settings.php?user_id=<?php echo $user_id; ?>">Einstellungen</a>
                </div>

            </li>
        </ul>
        <div>
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true"
                       aria-expanded="false">Notifications


                        <?php
                        $status = 'unread';
                        $message = 'message';
                        $fehler = false;

                        $checkfollow = $pdo->prepare("SELECT * FROM follow WHERE follow_id=$meine_id");
                        $checkfollow->execute();
                        $follower = $checkfollow->rowCount();

                        if ($follower > 0) {

                        //Wenn man jemandem folgt, werden die Posts der User, denen man folgt, angezeigt
                        while ($row = $checkfollow->fetch()) {
                            $userid = $row['user_id'];
                            $show_posts = $pdo->prepare("SELECT * FROM beitrag WHERE beitrag_user_id  = $userid");

                            $show_posts->execute();
                            $numberbeitrag = $show_posts->rowCount();


                            if ($numberbeitrag > 0) {

                                $insertnotification = $pdo->prepare("INSERT INTO notification (meine_id, posts_id, message, follow_user_id, status, datum) VALUES ($meine_id, $beitrag_id, 'message', $user_id, 'unread', $date)");
                                $insertnotification->bindParam(':meine_id', $meine_id);
                                $insertnotification->bindParam(':posts_id', $beitrag_id);
                                $insertnotification->bindParam(':follow_user_id', $userid);
                                $insertnotification->bindParam(':datum', $date);
                                $inserted = $insertnotification->execute();
                                var_dump($inserted);
                                while ($row3 = $insertnotification->fetch()) {

                                    $notification = $pdo->prepare("SELECT * FROM vlj_notification WHERE status = 'unread' AND beitrag_user_id = $userid ORDER BY 'date' DESC");
                                    $notification->execute();
                                    $donotification = $notification->rowCount();

                                    if ($donotification > 0) {

                                        ?>              <span
                                            class="badge-badge-light"><?php echo $donotification; ?></span></span>
                                        <?php
                                    }
                                }
                            }
                        }

                        ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdown01">
                        <?php
                        $notification2 = $pdo->prepare("SELECT * FROM vlj_notification ORDER BY 'date' DESC");
                        if ($donotification > 0) {
                            $row = $notification2->fetch();
                            $datum = $row['datum'];
                            $message = $row['message'];
                            $benutzername = $row['benutzername'];
                            ?>
                            <a style="
                    <?php
                            if ($message == "message") {
                                echo "font-weight:bold;";
                            }
                            ?>" class="dropdown-item" href="hauptseite.php?user_id=<?php echo $user_id; ?>">
                                <small><i><?php echo date('F j, Y, g:i, a', strtotime($datum)); ?></i></small>
                                <br/>
                                <?php
                                if ($message == "message") {
                                    echo $benutzername;
                                    echo "hat was Neues gepostet";
                                }
                                ?>

                            </a>
                            <div class="dropdown-divider"></div>
                            <?php
                        } else {
                            echo "Es ist noch nichts Neues gepostet worden.";
                        }
                        }

                        ?>
                    </div>




        </div>

        <form class="form-inline my-2 my-lg-0" method = "post">
            <input class="form-control mr-sm-2" name="suche" type="search" placeholder="Suchen" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Suche</button>
        </form>
        <?php
        //Suchfunktion

        if (isset($_POST["suche"])) {
            $allebenutzername = $_POST["suche"];

            $benutzersuche = $pdo->prepare("SELECT * FROM profilbildlogin WHERE benutzername = '$allebenutzername' AND aktiviert = 1");
            if ($benutzersuche->execute()) {

                while ($row = $benutzersuche->fetch()) {
                    $userid = $row ['login_id'];
                    ?>
                    <h3>
                        <a href="profilseite.php?user_id=<?php echo $userid ?>"><img
                                    src="<?php echo $row['profilbildtext'] ?>"></a>
                        <a href="profilseite.php?user_id=<?php echo $userid ?>"><?php echo $row['benutzername'] ?></a>
                    </h3>

                    <?php
                }
            } else {
                echo "<div>No user found</div>";
            }
        }
        ?>


        <button type="button" class="btn btn-dark"><a href="logout.php">Log Out</a></button>
    </div>
</nav>


</body>
</html>

