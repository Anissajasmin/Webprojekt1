<?php

$name = $_POST["text"];
echo $name;

$pdo=new PDO('mysql:: host=mars.iuk.hdm-stuttgart.de;
dbname=u-nk093', 'nk093', 'oHae6Johxa',
    array('charset'=>'utf8'));

$statement = $pdo->prepare("INSERT INTO login (id_login, content) VALUES (NULL, :name)");
$statement->execute(array("name"=>$name ));
echo "id in der Datenbank: ".$id=$pdo->lastInsertId();

$statement = $pdo->prepare("SELECT * FROM login");
if($statement->execute()) {
    while($row=$statement->fetch()) {
        echo $row['id_login']." ".$row['content'];
    }
} else {
    echo "Datenbank-Fehler:";
    echo $statement->errorInfo()[2];
    echo $statement->queryString;
    die();
}