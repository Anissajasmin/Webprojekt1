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
$status = 'unread';
$message = 'message';
$fehler = false;

    $checkfollow=$pdo->prepare("SELECT * FROM follow WHERE follow_id=$meine_id");
    if ($checkfollow->execute()){
    while ($row2 = $checkfollow->fetch()){
    $userid = $row2['user_id'];

if ($holebeitragid = $pdo->prepare("SELECT * FROM beitrag WHERE beitrag_user_id  = '$userid' ORDER BY beitrag_id DESC LIMIT 5 ")){
    if ($holebeitragid->execute()) {
        $zahlbeitragid = $holebeitragid->rowCount();

        while ($row = $holebeitragid->fetch()) {
            $beitrag_id = $row['beitrag_id'];
            $date = $row['zeitstempel'];

                $insertnotification = $pdo->prepare("INSERT INTO notification (meine_id, posts_id, message, follow_user_id, status, datum) VALUES (:meine_id, :posts_id, :message, :follow_user_id, :status, :datum)");
                $insertnotification->bindParam(':meine_id', $meine_id);
                $insertnotification->bindParam(':posts_id', $beitrag_id);
                $insertnotification->bindParam(':message', $message);
                $insertnotification->bindParam(':follow_user_id', $userid);
                $insertnotification->bindParam(':status', $status);
                $insertnotification->bindParam(':datum', $date);

                $inserted = $insertnotification->execute(array(':meine_id' => $meine_id, ':posts_id' => $beitrag_id, ':message' => $message, ':follow_user_id' => $userid, ':status' => $status, ':datum' => $date));

        }
    }
}
    }
    }


                $notification = $pdo->prepare("SELECT * FROM vlj_notification WHERE status = 'unread' AND meine_id = '$meine_id' ORDER BY 'zeitstempel' DESC");
                $notification->execute();
                $donotification = $notification->rowCount();

                if ($donotification > 0) {

                    ?>              <span class="badge-badge-light"><?php echo $donotification; ?></span></span>
                    <?php

        }

?>
            </a>
            <div class="dropdown-menu" aria-labelledby="dropdown01">
                <?php
                if ($donotification > 0) {
                    while ($row3 = $notification->fetch()){
                    $date = $row3['zeitstempel'];
                    $n_id = $row3['notification_id'];
                    $benutzername = $row3['benutzername'];
                    ?>
                    <a style="
                    <?php
                    if ($status == $row3['status']) {
                        echo "font-weight:bold;";
                    }
                    ?>" class="dropdown-item" href="postvnotification.php?n_id=<?php echo $n_id; ?>">
                        <small></small><?php echo date('F j, Y, g:i, a', strtotime($date)); ?></small>
                        <br/>
                        <?php
                        if ($status == $row3['status']) {
                            echo $benutzername;
                            echo '&nbsp';
                            echo "hat was Neues gepostet";
                        }
                        ?>
                    </a>
                    <div class="dropdown-divider"></div>
                    <?php
                } }else {
                    echo "Es ist noch nichts Neues gepostet worden.";
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
