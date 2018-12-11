<?php
session_start();
include ('datenbankpasswort.php');

if(isset($_GET['mail']) && !empty($_GET['mail']) AND isset($_GET['hash']) && !empty($_GET['hash'])) {
    $mail = $_GET['mail']; // EMail Variable setzen
    $hash = $_GET['hash']; // Hash Variable setzen


    $search = $pdo->prepare("SELECT hdm_mail, hash FROM login WHERE hdm_mail='" . $mail . "' AND hash='" . $hash . "'");
    $match = $search->execute();
    echo $match;
    if ($match > 0) {
    // Aktiviere den Account
    echo '<div>Dein Account wurde erfolgreich aktiviert, du kannst dich jetzt <a href="login.php">einloggen</a>';
} else {
    // Aktivierung fehlgeschlagen
    echo '<div>Leider war die Aktivierung nicht erfolgreich oder du hast deinen Account bereits aktiviert.</div>';
}
}else{
    // Zuerst muss Account aktiviert werden
    echo '<div>Bitte nutze den Link, den wir dir an deine HdM-Mail geschickt haben</div>';
}
