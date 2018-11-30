<html>
<head></head>
<body>
<form action="" method="post">
    <input type="submit" name="folgen" value="folgen">
</form>
<?php
session_start();

if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {

    header ("Location: login.php");
}
include ("datenbankpasswort.php");


 if (isset($_POST['folgen'])) {
                        $login_id = $pdo->query('SELECT login_id FROM login WHERE benutzername = :benutzername')[0]['login_id'];
                        $follow_id = $pdo->query('SELECT status FROM login WHERE status = "online" ORDER BY benutzername');

                        if (!$pdo->query('SELECT follow_id FROM follow WHERE login_id = :login_id')) {

                                $pdo->query('INSERT INTO follow VALUES (\'\', :login_id, :follow_id)');
                        } else {
                                echo 'Du folgst diesem User bereits';
                        }
                } else {
                die('Benutzer wurde nicht gefunden!');
        }


?>
</body>
</html>
