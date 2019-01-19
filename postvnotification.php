<?php
session_start();
include_once "logincheck.php";
if (!isset($_SESSION['login-id'])) {
    echo "Aktiviere zuerst deinen Account mittels der Email, die wir dir geschickt haben oder registriere dich zuerst. <a href=\"Startseite.php\">Zur Startseite</a>";
}else {include "header.php";
    ?>
    <!doctype html>
<html lang="en">
  <head>
      <title>TOUCH</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <link rel="stylesheet" type="text/css" href="postvnotification.css">
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
  </head>
  <body>
  <br>
  <br>
  <br>
  <div>
  <?php

$user_id = $_GET['user_id'];
    $n_id = $_GET['n_id'];
    $status1 = 'unread';
    $status = 'read';

    $searchnotification = $pdo->prepare("SELECT * FROM notification WHERE notification_id ='" . $n_id . "' AND status='" . $status1 . "'");
    $match = $searchnotification->execute();
    if ($match > 0) {


        $updatenotification = $pdo->prepare("UPDATE notification SET status = 'read' WHERE notification_id= '" .$n_id . "'");
        $updatenotification->bindParam(':notification_id', $n_id);
        $updatenotification->execute();

        $notification = $pdo->prepare("SELECT * FROM vlj_notification WHERE notification_id = $n_id");
        $notification->execute();
        while ($row = $notification->fetch()) {

            $post = $row['posts'];
            $postbild = $row ['bildtext'];
            $benutzername = $row['benutzername'];
            ?>



         <div id="postnotkasten">

         <p id="postnotname">  <?php echo $benutzername;
             echo '&nbsp';
             echo "hat etwas Neues gepostet:"; ?>
         </p>
             <?php echo '&nbsp'; ?>
             <div id="postnotkasten2">
             <p id="postnotpost">  <?php echo $post; ?>
           <?php echo "<img src='" . $postbild . "'>"; ?>
             </p>
         </div>
        <?php
            }
    }
    ?>
  <br/>
  <button id="postnotbutton" href="hauptseite.php?user_id=<?php echo $user_id; ?>">Zurück zum Feed</button>
  </div>
  </body>
    </html>

<?php
}
?>