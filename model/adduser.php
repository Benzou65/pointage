<?php
require_once('../controller/functions.php');

try
{
	// On vérifie que les données en input sont bonnes
	if (checkRegistrationForm($_POST)) {
		// Hachage du mot de passe
		$lPassHach = password_hash($_POST['psw'], PASSWORD_DEFAULT);

		$lDBO = new PDO('mysql:host=localhost:3306;dbname=pointage;charset=utf8', '**********', '************', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		
		// On récupère l'id de la classe dans de la table class
		$readClass = $lDBO->prepare('SELECT id FROM class WHERE class_ref = ?');
		$readClass->execute(array($_POST['classe']));
		$donneesClass = $readClass->fetch();
		$readClass->closeCursor();
		$userIdClass = $donneesClass['id'];

		// On vérifie que l'adresse n'est pas déjà utilisé
		$readUser = $lDBO->prepare('SELECT user_email FROM users WHERE user_email = ?');
		$readUser->execute(array($_POST['email']));
		$donneesUser = $readUser->fetch();
		$readUser->closeCursor();
		if(!$donneesUser['user_email'])
		{
			$write = $lDBO->prepare('INSERT INTO users (user_email, user_password, user_first_name, user_name, id_class) VALUES(?, ?, ?, ?, ?)');
			$write->execute(array($_POST['email'], $lPassHach, $_POST['prenom'], $_POST['nom'], $userIdClass));
		}
		else
		{
			header("Location: ../view/inscription.php?error=4"); // return "Adresse mail déjà utilisée.";
			exit;
		}
	}
	else{
		header("Location: ../index.php"); // Pas de code d'erreur car ca veux dire que le mec à truquer les $_POST
		exit;
	}
}
catch (PDOException $e)
{
	print "Erreur !: " . $e->getMessage() . "<br/>";
	die();
}


header("Location: ../index.php");