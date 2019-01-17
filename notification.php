<?php
session_start();
include_once "datenbankpasswort.php";
$meine_id = $_SESSION["login-id"];
$user_id = $_GET['user_id'];
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
  </head>
  <body>
  <nav>
      <div>
    <ul class="navbar-nav mr-auto">
        <li class="nav-item dropdown">
            <a class="nav-link" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Notifications

<?php

    $checkfollow=$pdo->prepare("SELECT * FROM follow WHERE follow_id=$meine_id");
    $checkfollow->execute();
    $follower=$checkfollow->rowCount();

    if($follower > 0) {

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
            $insertnotification->execute();
            while ($row3 = $insertnotification->fetch()) {

                $notification = $pdo->prepare("SELECT * FROM vlj_notification WHERE status = 'unread' AND beitrag_user_id = $userid ORDER BY 'date' DESC");
                $notification->execute();
                $donotification = $notification->rowCount();

                if ($donotification > 0) {

                    ?>              <span class="badge-badge-light"><?php echo $donotification; ?></span></span>
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
    </li>
    </ul>


  </div>
</nav>


    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</body>
</html>
