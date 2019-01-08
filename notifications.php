<?php
session_start();
include_once "datenbankpasswort.php";
include "logincheck.php";
include "includedesign.php";

$meine_id = $_SESSION["login-id"];

if ($getbeitragid = $pdo->prepare("SELECT * FROM beitrag WHERE user_id = $meine_id ORDER BY beitrag_id DESC LIMIT 1")) {
    if ($getbeitragid->execute()) {
        if ($row = $getbeitragid->fetch()) {
            $beitrag_id = $row['beitrag_id'];
        }
    }
}

$show_follower = $pdo->prepare("SELECT * FROM follow WHERE user_id= $meine_id");
if ($show_follower->execute()) {
    while ($row3 = $show_follower->fetch()) {
        $follow_id = $row3['follow_id'];

        $notification = $pdo->prepare("INSERT INTO notification (meine_id, beitrag_id, follower_id) VALUES (:meine_id, :beitrag_id, :follow_id)");
        $notification->bindParam(':meine_id', $meine_id);
        $notification->bindParam(':beitrag_id', $beitrag_id);
        $notification->bindParam(':follow_id', $follow_id);
        $notification->execute();
        echo '<script>window.location.href="hauptseite.php"</script>';
    }
}