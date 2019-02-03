<?php
//Nutzer, denen man noch nicht folgt werden hier angezeigt
//Wird dem Benutzer bereits gefolgt?
$checkfollow = $pdo->prepare("SELECT * FROM follow WHERE follow_id='" . $my_id . "'");
$checkfollow->execute();
$notfollowing = $checkfollow->rowCount();
if (!$notfollowing > 0) {
    $showallusers = $pdo->prepare ("SELECT * FROM profilbildlogin WHERE NOT login_id = $my_id LIMIT 3");
    $showallusers->execute();
    while ($row1 = $showallusers->fetch()){
        $allusers = $row1['login_id'];
        echo "<div id=\"tabelleposts\">";
        echo "<span>";
        ?>
        <div id="kasten">
            <a href="profilseite.php?user_id=<?php echo $allusers ?>"><img id="recommendationprofilbild" src="<?php echo $row1['profilbildtext'] ?>"></a>
            <a style="text-decoration:none;" href="profilseite.php?user_id=<?php echo $allusers ?>"><div id="kastentext"><?php echo $row1['benutzername'] ?></div></a>
        </div>
        <?php
        echo "</span>";
        echo "</div>";
    }
} else{
    $row = $checkfollow->fetch();
    $userid = $row['user_id'];
    $my_id = $row ['follow_id'];
    //Wenn man jemandem nicht folgt, werden die Namen der Personen, denen man nicht folgt, in dieser Liste angezeigt
    $show_users = $pdo->prepare("SELECT * FROM profilbildlogin WHERE NOT login_id = $my_id AND NOT login_id = $userid LIMIT 3");
    $show_users->execute();
    while($row3 = $show_users->fetch()) {
        $users = $row3['login_id'];
        echo "<div id=\"tabelleposts\">";
        echo "<span>";
        ?>
        <div id="kasten">
            <a href="profilseite.php?user_id=<?php echo $users ?>"><img id="recommendationprofilbild" src="<?php echo $row3['profilbildtext'] ?>"></a>
            <a style="text-decoration:none;" href="profilseite.php?user_id=<?php echo $users ?>"><div id="kastentext"><?php echo $row3['benutzername'] ?></div></a>
        </div>
        <?php
        echo "</span>";
        echo "</div>";
    }
}
?>