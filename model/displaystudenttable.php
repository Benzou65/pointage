<?php
try
{
	$lDBO = new PDO('mysql:host=localhost:3306;dbname=pointage;charset=utf8', '**********', '************', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	
	$read = $lDBO->query('SELECT user_first_name, user_name, morning_hour, afternoon_hour FROM users JOIN checkin_time ON users.id = checkin_time.id_users WHERE day = CURDATE() ORDER BY user_name');
    while ($donnees = $read->fetch())
    {
        require('../view/displaystudent.php');
    }
    $read->closeCursor();
}
catch (PDOException $e)
{
	print "Erreur !: " . $e->getMessage() . "<br/>";
	die();
}