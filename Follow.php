<html>
<head></head>
<body>

<?php

include("datenbankpasswort.php");

$benutzername = "";


if (isset($_POST['folgen'])) {
    $benutzername = $pdo->query('SELECT benutzername FROM login WHERE benutzername = :benutzername', array(':benutzername' => $_POST ['benutzername']))[0]['login_id'];


    if ($pdo->query('SELECT login_id FROM login WHERE login_id = :login_id', array('benutzername' => $_GET ['benutzername']))) {

        $pdo->query('INSERT INTO follow VALUES (\'\', :login_id, :follow_id)');

        if (isset($_POST ['folgen'])) {

            $login_id = $pdo->query('SELECT login_id FROM login WHERE benutzername = :benutzername', array(':benutzername' => $_GET['benutzername'])[0][$login_id]);

            $follow_id = login:: isLoggedIn();


        }
        if (!$pdo->query('SELECT follow_id FROM follow WHERE login_id=:login_id', array('unser_id' => $_POST['user_id']))) {
            $pdo->query('INSERT INTO follow VALUES (\'\', :login_id, :follow_id)', array(':login_id' => $login_id, 'follow_id' => $follow_id));


        } else {
            echo "Du folgst dieser Person bereits!";
        }


    } else {
        die('Benutzer wurde nicht gefunden!');
    }
}


?>

<h1> <?php echo $benutzername; ?> ´s Profil </h1>


<form action="Follow.php?benutzername=<?php echo $benutzername; ?>" method="post">
    <input type="submit" name="folgen" value="Folgen">
</form>


</body>
</html>
