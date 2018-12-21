
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
$benutzername = $_SESSION ['username'];
$benutzername2 =$pdo->prepare("SELECT benutzername FROM login WHERE login_id= '" . $user_id . "'") ->execute();



// Ist es ein fremdes Profil?
if ($user_id != $_SESSION['login-id']) {

// Wird dem Benutzer bereits gefolgt?
    $checkfollow = $pdo->prepare("SELECT follow_id FROM follow WHERE user_id='" . $user_id . "' AND follow_id='" . $follow_id . "'");
    $checkfollow->execute();

    $notfollowing = $checkfollow->rowCount();

    if (!$notfollowing > 0) {
        ?>


        <?php

        if (isset($_POST['follow'])) {
            $follow = $pdo->prepare("INSERT INTO follow (user_id, follow_id) VALUES (:user_id, :follow_id)");
            $follow->bindParam(':user_id,', $user_id);
            $follow->bindParam(':follow_id,', $follow_id);

            if ($follow->execute()) {

                echo '<script> window.location.href="profilseite.php?user_id=' . $user_id . '"</script>';
            }
        }


    }
}

?>
<h1> <?php echo $benutzername2; ?> ´s Profil </h1>


<form action="profilseite.php?user_id=<?php echo $user_id ?>" method="post">
    <input type="submit" name="follow" value="Folgen">
</form>
</body>
</html>
