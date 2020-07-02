<?php
require_once('./functions.php');

$key = randomMail();
$waitingTime = 300; // Nombre de secondes d'attente avant renvoi de mail

try {
	if ( checkMail($_POST['email'])) {
		// Hachage du mot de passe
		$lKeyHash = password_hash($key, PASSWORD_DEFAULT);

		$lDBO = new PDO('mysql:host=localhost:3306;dbname=pointage;charset=utf8', '**********', '************', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		
		// On vérifie que l'adresse email existe dans la BDD
		$read = $lDBO->prepare('SELECT user_email, reset_key_timer FROM users WHERE user_email = ?');
		$read->execute(array($_POST['email']));
		$donnees = $read->fetch();
		$read->closeCursor();
		if(!empty($donnees['user_email'])) {
			if (!is_null($donnees['reset_key_timer'])) {
				$remainingTime = $waitingTime - (time() - $donnees['reset_key_timer']);
				if($remainingTime < 0) {
					$write = $lDBO->prepare('UPDATE users SET reset_key = ?, reset_key_timer = ? WHERE user_email = ?');
					$write->execute(array($lKeyHash, time(), $_POST['email']));
					mailRecup($key);
				}
				else {
					header("Location: ../view/lostpassword.php?error=8&time=$remainingTime");
					exit;
				}
			}
			else {
				$write = $lDBO->prepare('UPDATE users SET reset_key = ?, reset_key_timer = ? WHERE user_email = ?');
				$write->execute(array($lKeyHash, time(), $_POST['email']));
				mailRecup($key);
			}
		}
		else {
			header("Location: ../view/lostpassword.php?error=6");
			exit;
		}
	}	
}
catch (PDOException $e) {
	print "Erreur !: " . $e->getMessage() . "<br/>";
	die();
}


// REDIRECTION
header("Location: ../index.php");