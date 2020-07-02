<?php
session_start();
date_default_timezone_set('Europe/Paris');
setlocale (LC_TIME, 'fr_FR.utf8','fra');
$lHour1 = strtotime('8:45:00');
$lHour2 = strtotime('12:30:00');
$lHour3 = strtotime('13:15:00');
$lHour4 = strtotime('23:59:00');

try
{
	$lDBO = new PDO('mysql:host=localhost:3306;dbname=pointage;charset=utf8', '**********', '************', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    
    if ( time() > $lHour1 && time() < $lHour2 )
    {
        $read = $lDBO->prepare('SELECT morning_hour FROM checkin_time WHERE day = CURDATE() AND id_users = ?');
        $read->execute(array($_SESSION['id']));
        $donnees = $read->fetch();
        $read->closeCursor();
        // On vérifie que la ligne est vide
        if(empty($donnees))
        {
            // Ecriture Date et Heure pointage de l'après midi
            $write = $lDBO->prepare('INSERT INTO checkin_time (day, morning_hour, id_users) VALUES (CURDATE(), CURTIME(), ?)');
            $write->execute(array($_SESSION['id']));
            header("Location: ../index.php");
            exit;
        }
        else
        {
            header("Location: ../view/checkin.php?error=1");
            exit;
        }
    }
    else if ( time() > $lHour3 && time() < $lHour4 )
    {
        $read = $lDBO->prepare('SELECT afternoon_hour FROM checkin_time WHERE day = CURDATE() AND id_users = ?');
        $read->execute(array($_SESSION['id']));
        $donnees = $read->fetch();
        $read->closeCursor();
        // On vérifie que la ligne n'existe pas
        if(empty($donnees))
        {
            // Ecriture Date et Heure pointage de l'après midi
            $write = $lDBO->prepare('INSERT INTO checkin_time (day, afternoon_hour, id_users) VALUES (CURDATE(), CURTIME(), ?)');
            $write->execute(array($_SESSION['id']));
            header("Location: ../index.php");
            exit;
        }
        // Si elle existe mais que la colonne afternoon_hour vaux NULL alors on modifie le tupple.
        else if ( is_null($donnees['afternoon_hour']) )
        {
            $write = $lDBO->prepare('UPDATE checkin_time SET afternoon_hour = CURTIME() WHERE day = CURDATE() AND id_users = ?');
            $write->execute(array($_SESSION['id']));
            header("Location: ../index.php");
            exit;
        }
        else
        {
           header("Location: ../view/checkin.php?error=2");
           exit;
        }
    }
    else
    {
        header("Location: ../view/checkin.php?error=3");
        exit;
    }


}
catch (PDOException $e)
{
	print "Erreur !: " . $e->getMessage() . "<br/>";
	die();
}