<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profilseite</title>
    <link rel="stylesheet" type="text/css" href="profilseite.css">
    <meta name = "viewport" content="width-device-width, initial-scale=1.0, maximum-scale=1.0, user scalelable=no">
</head>

<?php
session_start();
include_once "logincheck.php";
if (!isset($_SESSION['login-id'])) {
    echo "Bitte logge dich ein oder registriere dich zuerst. <a href=\"Startseite.php\">Zur Startseite</a>";
}else{
    include ("datenbankpasswort.php");
?>





<body>


<div id="profilseite">

    <div class id="header">
        <h1>TOUCH </h1>


        <div id = "searcharea" class ="header"><input placeholder= "Search here..." type="text" id="searchbox"/></div>
        <a style="text-decoration:none;" href="">
            <div id="notificationneu"><img src="notificationneu.png"/><div>
        </a>


        <a style="text-decoration:none;" href="">
            <div id="messageneu"><img src="messageneu.png"/><div>
        </a>


        <a style="text-decoration:none;" href="">
            <div id="settingneu"><img src="settingneu.png"/><div>
        </a>


    </div>

     <div class="header1"
        </div>
      <div class="coverpad">
      </div>



    <div id="main">

        <div id="recommondation">
            <h2 class="ueberschriftenmain"> Recommondations
            </h2>
        </div>
        <a style="..." href="">
            <div class="button8">Touches</div>
        </a>
    </div>



<div id="background">

    <a style="..." href="">
        <div class="button1">Save</div>
    </a>

    <a style="..." href="">
        <div class="button2">Settings</div>
    </a>


        <div class="button3">Friends</div>



        <div class="button4">Posts</div>



        <div class="button5">Touches</div>



        <div id="tabellename">
            <table class="tabelle1">


            <?php
            $benutzername = $_POST["benutzername"];
                $stmt = $pdo->prepare("SELECT * FROM login WHERE benutzername = :benutzername ");
                $result = $stmt->execute(array(':benutzername' => $benutzername));
            while ($row = $stmt->fetch()) {
                echo "<tr>";
                echo "<td>" . $row["benutzername"] . "</td>"; }
            ?>




            </table>

            </div>


        <div id="tabelleemail">
         <table class="tabelle2">
             <thead>
          <tr>
          <th>E-Mail</th>
           </tr>
             </thead>

                        <?php
                        $mail = $_POST["hdm_mail"];
                        $stmt = $pdo->prepare("SELECT * FROM login WHERE mail = :hdm_mail");
                        $result = $stmt->execute(array(':hdm_mail' => $mail));
                        while ($row = $stmt->fetch()) {
                            echo "<tr>";
                            echo "<td>" . $row["hdm_mail"] . "</td>"; }
                        ?>
        </table>

        </div>



    <a style="..." href="">
        <div class="button9">Upload picture</div>
    </a>


    <div class = "button10"></div>
    <div id="ueberschrift">
        <h3> Your Profile</h3>
    </div>


    <form id=postbox2 action="login.php" method="post">
        <textarea id="text" name="text" placeholder="Write something..." cols="40" rows="4">
        </textarea>
        <br>
        <input type="submit">
    </form>





</div>
</body>
</html>
    <?php
}
?>


