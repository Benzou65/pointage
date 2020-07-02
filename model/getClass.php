<?php
// Récupère les différentes classe (scolaire) dans la BDD
function getClass() {
	try
    {
        $lDBO = new PDO('mysql:host=localhost:3306;dbname=pointage;charset=utf8', '**********', '************', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        
        $read = $lDBO->query('SELECT class_ref FROM class ORDER BY class_ref');
        while ($donnees = $read->fetch())
        {
            $class[] = $donnees['class_ref'];   
        }
        $read->closeCursor();
        //var_dump($class);
        return $class;
    }
    catch (PDOException $e)
    {
        print "Erreur !: " . $e->getMessage() . "<br/>";
        die();
    }
}