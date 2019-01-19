</bod>
<div id="navbar">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand">TOUCH</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="hauptseite.php?user_id=<?php echo $user_id; ?>">Mein Feed <span
                                class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        Profil
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="profilseite.php?user_id=<?php echo $user_id; ?>">Mein Profil</a>
                        <a class="dropdown-item" href="settings.php?user_id=<?php echo $user_id; ?>">Einstellungen</a>
                    </div>

                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="meinefreunde.php?user_id=<?php echo $user_id; ?>">Meine Freunde <span
                                class="sr-only">(current)</span></a>
                </li>
            </ul>
            <div>
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item dropdown">
                        <a class="btn btn-outline-dark" style="font-family: 'Helvetica Neue'; font-size:120%; font-weight: 200;" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true"
                           aria-expanded="false"> Notifications

                            <?php
                            include_once"notification.php"
                            ?>

            </div>


            <?php
            //Suchfunktion
            if (isset($_POST["suche"])) {
                $allebenutzername = $_POST["suche"];
                $benutzersuche = $pdo->prepare("SELECT * FROM vlj_loginprofilbild WHERE benutzername = '$allebenutzername' AND aktiviert = 1");
                if ($benutzersuche->execute()) {
                    while ($row = $benutzersuche->fetch()) {
                        $userid = $row ['login_id'];
                        ?>
                        <h3>
                            <a href="profilseite.php?user_id=<?php echo $userid ?>"><img
                                        src="<?php echo $row['profilbildtext'] ?>"></a>
                            <a href="profilseite.php?user_id=<?php echo $userid ?>"><?php echo $row['benutzername'] ?></a>
                        </h3>

                        <?php
                    }
                } else {
                    echo "<div>No user found</div>";
                }
            }
            ?>


        </div>

        <form class="form-inline my-2 my-lg-0 " style="color:red;">
            <input class="form-control mr-sm-2 " style="font-family: 'Helvetica Neue'; font-size:120%; font-weight: 200;"name="suche" type="search" placeholder="Suchen" aria-label="Search">
            <button class="btn btn-outline-dark my-2 my-sm-0" id="suchebutton" type="submit">Suche</button>
        </form>


        <button type="button"  class="btn btn-outline-dark " style=" font-family: 'Helvetica Neue'; color:white; font-size:120%; font-weight: 200; background-color:#7B0202;"" ><a style= color:white; href="logout.php">Log Out</a></button>


    </nav>
</div>

</body>
</html>