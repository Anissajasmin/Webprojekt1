<?php
session_start();
include_once "datenbankpasswort.php";
$meine_id = $_SESSION["login-id"];
$user_id = $_GET['user_id'];
?>
<!doctype html>
<html lang="de">
  <head>
    <meta charset="utf-8">
      <link rel="stylesheet" type="text/css" href="unnötig/postvnotification.css">
  </head>
  <body>

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
                        <small><?php echo date('F j, Y, g:i, a', strtotime($date)); ?></small>
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
                    ?>
                <p id="not1">
                   <?php echo "Es ist noch nichts Neues gepostet worden.";
                }

?>
                </p>
    </div>
  </body>
</html>
