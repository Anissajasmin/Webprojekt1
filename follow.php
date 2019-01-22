
<!DOCTYPE html>
<html>
<head>
    <title>Follow</title>
    <link rel="stylesheet" type="text/css" href="profilseite.css">
</head>
<body>

<?php

include("datenbankpasswort.php");
include ("logincheck.php");

$user_id= $_GET['user_id'];
$follow_id = $_SESSION['login-id'];

// Ist es ein fremdes Profil?
if ($user_id != $_SESSION['login-id']) {

// Wird dem Benutzer bereits gefolgt?
    $checkfollow = $pdo->prepare("SELECT follow_id FROM follow WHERE user_id='" . $user_id . "' AND follow_id='" . $follow_id . "'");
    $checkfollow->execute();

    $notfollowing = $checkfollow->rowCount();

    if (!$notfollowing > 0) {
        ?>
        <form action="profilseite.php?user_id=<?php echo $user_id ?>" method="post">
            <input id="followbutton" type="submit" name="follow" value="Folgen">
                <style media="screen">
                    #followbutton {
                        float:right;
                        margin-top: 20px;
                    }


                </style>

                </form>

        <?php

        if (isset($_POST["follow"])) {
            $follow = $pdo->prepare('INSERT INTO follow (follow_id, user_id) VALUES (:follow_id, :user_id)');
            $follow->bindParam(':follow_id,', $follow_id);
            $follow->bindParam(':user_id,', $user_id);
            $followergebnis = $follow->execute(array(':follow_id' => $follow_id, ':user_id' => $user_id));

            if ($followergebnis) {

                echo '<script>window.location.href="profilseite.php?user_id=' . $user_id . '"</script>';
            }
        }


    }

    else {
        //Unfollow
        ?>

<form action="profilseite.php?user_id=<?php echo $user_id?>" method="post">
    <input type="submit" name="unfollow" value="Entfolgen">
</form>

<?php
        if (isset($_POST['unfollow'])) {
            $unfollow = $pdo -> prepare("DELETE FROM follow WHERE user_id='" . $user_id . "' AND follow_id='" . $follow_id . "'");
            if ($unfollow->execute()) {
                echo '<script>window.location.href="profilseite.php?user_id='.$user_id.'"</script>';
            }

        }


    }



}

?>


</body>
</html>
