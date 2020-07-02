<?php
require_once('dbName.php');

$lDBO = new PDO('mysql:host=localhost:3306;dbname=pointage;charset=utf8', '**********', '************', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

foreach($dbName as $perso) {
    $email = strtolower($perso[0]) . strtolower($perso[1]) . "@pointage.fr";

    $read = $lDBO->prepare('SELECT id FROM users WHERE user_email = ?');
    $read->execute(array($email));
    $donneesId = $read->fetch();
    $read->closeCursor();
    $userId = $donneesId['id'];
    
    $morningTime = '08:' . random_int(45,59) . ':00';
    $afternoonTime = '13:' . random_int(15,29) . ':00';

    $write = $lDBO->prepare('INSERT INTO checkin_time (day, morning_hour, afternoon_hour, id_users) VALUES (CURDATE(), ?, ?, ?)');
    $write->execute(array($morningTime, $afternoonTime, $userId));
}