<!DOCTYPE html>
<html>
<head>
    <title>Follow</title>
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
    $checkfollow = $pdo->prepare("SELECT follow_id FROM followlogin WHERE user_id='" . $user_id . "' AND follow_id='" . $follow_id . "'");
    $checkfollow->execute();

    $notfollowing = $checkfollow->rowCount();

    if (!$notfollowing > 0) {
        ?>
        <form action="profilseite.php?user_id=<?php echo $user_id ?>" method="post">
            <input type="submit" name="follow" value="Folgen">
        </form>

        <?php

        if (isset($_POST['follow'])) {
            $follow = $pdo->prepare("INSERT INTO followlogin (follow_id, user_id) VALUES (:follow_id, :user_id)");
            $follow->bindParam(':follow_id,', $follow_id);
            $follow->bindParam(':user_id,', $user_id);

            if ($follow->execute(array(':follow_id'=> $follow_id, ':user_id' => $user_id))) {

                echo '<script>window.location.href="profilseite.php?user_id=' . $user_id . '"</script>';
            }
        }


    }

    else {
        ?>
        //Unfollow
        <form action="profilseite.php?userid=<?php echo $user_id?>" method="post">
            <input type="submit" name="unfollow" value="Entfolgen">
        </form>

        <?php
        if (isset($_POST['unfollow'])) {
            $unfollow = $pdo -> prepare("DELETE FROM follow WHERE follow_id='" . $follow_id . "' AND user_id='" . $user_id . "'");
            if ($unfollow->execute()) {
                echo '<script>window.location.href="profile.php?user_id='.$user_id.'"</script>';
            }


        }


    }

}

?>
<h1> <?php echo $benutzername; ?> ´s Profil </h1>


</body>
</html>
