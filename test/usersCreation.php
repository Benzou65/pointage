<?php
require_once('dbName.php');



$lDBO = new PDO('mysql:host=localhost:3306;dbname=pointage;charset=utf8', '**********', '************', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

foreach($dbName as $perso) {
    $email = strtolower($perso[0]) . strtolower($perso[1]) . "@pointage.fr";
    $lPassHach = password_hash('123456', PASSWORD_DEFAULT);
    $prenom = $perso[0];
    $nom = $perso[1];
    $class = 1;

    $write = $lDBO->prepare('INSERT INTO users (user_email, user_password, user_first_name, user_name, id_class) VALUES(?, ?, ?, ?, ?)');
    $write->execute(array($email, $lPassHach, $prenom, $nom, $class));
}



