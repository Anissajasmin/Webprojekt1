<?php
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>TOUCH</title>
</head>
<body>
<h1>Login</h1>
<?php
$name = $_POST["text"];
echo $name;

$pdo=new PDO('mysql:: host=mars.iuk.hdm-stuttgart.de;
dbname=u-nk093', 'nk093', 'oHae6Johxa',
    array('charset'=>'utf8'));

$statement = $pdo->prepare("INSERT INTO id_login (content) VALUES (:name)");
$statement->execute(array(":name"=>$name ));
echo "id in der Datenbank: ".$pdo->lastInsertId(). "<br>";


if($statement->execute()) {
    while($row=$statement->fetch()) {
        echo $row['id_login']." ".$row['content'];
        echo "<br>";
    }
} else {
    echo "Datenbank-Fehler:";
    echo $statement->errorInfo()[2];
    echo $statement->queryString;
    die();
}


?>

</body>
</html>
