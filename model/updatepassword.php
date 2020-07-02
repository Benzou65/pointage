<?php
require_once('../controller/functions.php');

try
{
    if (checkRegistrationForm($_POST)) {
        $lDBO = new PDO('mysql:host=localhost:3306;dbname=pointage;charset=utf8', '**********', '************', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        
        // On va chercher la reset_key du mail
        $read = $lDBO->prepare('SELECT reset_key FROM users WHERE user_email = ?');
        $read->execute(array($_POST['email']));
        $donnees = $read->fetch();
        $read->closeCursor();

        // Vérif post key et reset_key BDD
        $lKeyOk = password_verify($_POST['key'], $donnees['reset_key']);
        $lPassHach = password_hash($_POST['psw'], PASSWORD_DEFAULT);

        if ( $lKeyOk ) {
            $write = $lDBO->prepare('UPDATE users SET user_password = ?, reset_key = ? WHERE user_email = ?');
            $write->execute(array($lPassHach,NULL,$_POST['email']));
        }
        else {
            header("Location: ../view/connect.php?error=7");
            exit;
        }
    }
    else {
        Header("Location: ../view/changepassword.php?error=5");
        exit;
	}
    header("Location: ../view/connect.php");
    exit;
}
catch (PDOException $e)
{
	print "Erreur !: " . $e->getMessage() . "<br/>";
	die();
}


