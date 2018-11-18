<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hauptseite</title>
    <link rel="stylesheet" type="text/css" href="hauptseite.css";
</head>
<body>

<div id="hauptseite">


    <div id="header">
        <h1>TOUCH</h1>

        <label id="suche1" for="suche">Search</label>
        <input type="search" id="suche" placeholder="Profile, ...">

    </div>



    <div id="main">

        <div id="recommondation">
            <h2 class="ueberschriftenmain"> Recommondations
            </h2>
        </div>

        <div id="background">

            <a style="text-decoration:none;" href="">
                <div id="buttonfriends">Friends</div>
            </a>



            <a style="text-decoration: none;" href="">
                <div id="buttonstudents">Students</div>
            </a>





            <form id= postbox2 action="Login_lesen.php" method="post">
                     <textarea id="text" name="text" placeholder="Post something" cols="40" rows="4">
                        Hallo
                      </textarea>
                <br>
                <input type="submit">
            </form>



        </div>



        <div id="profile">
            <h2 class="ueberschriftenmain"> Profile
            </h2>
        </div>

    </div>



</div>




</body>
</html>
