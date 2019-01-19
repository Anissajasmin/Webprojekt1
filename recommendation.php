

<div id="recommendation">
    <h2 class="ueberschriftenmain"> Recommendations
    </h2>

    <?php
    //Nutzer, denen man noch nicht folgt werden hier angezeigt
    //Wird dem Benutzer bereits gefolgt?
    $checkfollow = $pdo->prepare("SELECT follow_id FROM follow WHERE user_id='" . $user_id . "' AND follow_id='" . $follow_id . "'");
    $checkfollow->execute();
    $notfollowing = $checkfollow->rowCount();

    if (!$notfollowing >0) {
        $checkfollow=$pdo->prepare("SELECT * FROM follow WHERE follow_id=$my_id");
        $checkfollow->execute();
        $nofollower=$checkfollow->rowCount();

        //Wenn man jemandem nicht folgt, werden die Namen der Personen, denen man nicht folgt, in dieser Liste angezeigt
        while($row = $checkfollow->fetch()) {
            $userid = $row['user_id'];
            $show_users = $pdo->prepare("SELECT * FROM vlj_loginfollow WHERE follow_id!= $userid");
            $show_users->execute();

            $row3 = $show_users->fetch();

            echo "<div id=\"tabelleposts\">";
            echo "<span>";
            ?>
            <div id="kasten">
                <a style="text-decoration:none;" href="profilseite.php?user_id=<?php echo $userid ?>"><div id="kastentext"><?php echo $row3['benutzername'] ?></div></a>

            </div>
            <?php
            echo "</span>";
            echo "</div>";

        }
    }

    ?>

</div>


</div>


</body>
</html>