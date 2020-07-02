<?php
session_start();

try
{
	$lDBO = new PDO('mysql:host=localhost:3306;dbname=pointage;charset=utf8', '**********', '************', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	$read = $lDBO->prepare('SELECT id, user_password, login_attempt, login_attempt_timer FROM users WHERE user_email LIKE ?');
	$read->execute(array($_POST['email']));
	$user = $read->fetch();
	$read->closeCursor(); // ou $lBDO = null; ou unset($reponse);

	// calcule temps restant du timer
	// if(isnull(login_attempt_timer) || login_attempt_timer > 5min) 


	// Test du password recu avec celui de la base de donnée
	$lPassOk = password_verify($_POST['password'], $user['user_password']);
	// Si le pass est Ok on donne l'id à $_SESSION et on va sur checkin sinon retour à la page de connexion
	if ( $lPassOk )
	{
		$_SESSION['id'] = $user['id'];
		header("Location: ../view/checkin.php");
		exit;
	}
	else
	{
		// if(login_attempt < 3)
		// login_attempt++
		// header("Location: ../view/connect.php?error=9&attempt=$tentativeRestante");
		header("Location: ../view/connect.php?error=9");
		// elseif(login_attempt >= 3)
		// Write database le time dans login_attempt_timer 
		// header("Location: ../view/connect.php?error=XXX&timer=$login_attempt_timer_recalculated");
	}
}
catch (PDOException $e)
{
	print "Erreur !: " . $e->getMessage() . "<br/>";
	die();
}