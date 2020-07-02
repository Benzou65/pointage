<?php
// Teste la validité d'un email
function checkMail($pMail)
{
	if ( !empty($pMail) )
	{
		if ( isset($pMail) )
		{
			$exp = '/^[a-z0-9\._-]+@[a-z0-9\._-]+\.[a-z]{2,4}$/i';
			if ( preg_match($exp, $pMail) )
			{
				return true;
			}
		}
	}
	return false;
}

// Fonction de retour d'erreur
function displayError($pError, $pRemainingTime = "")
{  
	switch ($pError) {
		case '1':
			return "Vous avez déjà pointé ce matin.";
			break;
		case '2':
			return "Vous avez déjà pointé cet après midi.";
			break;    
		case '3':
			return "Ce n'est pas l'heure de travailler.";
			break;
		case '4':
			return "Adresse mail déjà utilisée.";
			break;
		case '5':
			return "Les mots de passe saisis ne sont pas identiques.";
			break;
		case '6':
			return "Adresse mail inconnue.";
			break;
		case '7':
			return "Veuillez refaire une demande de récupération de mot de passe.";
			break;
		case '8':
			return "Veuillez attendre $pRemainingTime secondes avant de refaire votre demande.";
			break;
		case '9':
			return "Adresse email ou mot de passe invalide";
			break;
		default:
			return "";
			break;
	}
}

// Vérification du formulaire d'inscription
function checkRegistrationForm($param) {
	if (!empty($param)) {
		if (isset($param)) {
			foreach($param as $key => $value)
			{
				if (empty($param[$key])) {
					return false;
				}
			}
			// Vérification longueur input
			if(
				strlen($_POST['prenom']) < 2 || 
				strlen($_POST['nom']) < 2 || 
				strlen($_POST['prenom']) > 255 || 
				strlen($_POST['nom']) > 255 ||
				strlen($_POST['email']) < 6 ||
				strlen($_POST['email']) > 255 ||
				strlen($_POST['psw']) < 6 ||
				strlen($_POST['psw']) > 255 ||
				strlen($_POST['confirm_psw']) < 6 ||
				strlen($_POST['confirm_psw']) > 255	) {
				return false;
			}
			// On vérifie si le password est le meme que confirm password
			if ($_POST['psw'] !== $_POST['confirm_psw']) {
				return false;
			}
			return true; //Tester et rajouter des false pour les autres conditions
		}
		return false;
	}
	return false;
}

// Création de clé random pour vérif mail
function randomMail() {
	$length = 12;
	$str = '';
	$keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$max = mb_strlen($keyspace, '8bit') - 1;
	if ($max < 1) {
			throw new Exception('$keyspace must be at least two characters long');
	}
	for ($i = 0; $i < $length; ++$i) {
			$str .= $keyspace[random_int(0, $max)];
	}
	return $str;
}

// ENVOIE DU MAIL ////////////////////////////////////////////////
function mailRecup($pKey) {
	// Plusieurs destinataires
	$to  = $_POST['email']; // notez la virgule

	// Sujet
	$subject = 'Changer votre mot de passe';

	// message
	$message =
		"
		<html>
		<head>
			<title>Changer votre mot de passe</title>
		</head>
		<body>
			<p>Salut $to</p>
			<p>Voici un lien pour réinialiser votre mot de passe :</p>
			<p><a href='www.pointage.fr/view/changepassword.php?key=$pKey'>Cliquez ici</a></p>
		</body>
		</html>
		"
	;

	// Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
	$headers[] = 'MIME-Version: 1.0';
	$headers[] = 'Content-type: text/html; charset=utf-8';

	// En-têtes additionnels
	//$headers[] = 'To: Mary <lionel.bonzoumet@gmail.com>';
	$headers[] = 'From: Pointeuse formation <contact@lionel-bonzoumet.fr>';

	// Envoi
	mail($to, $subject, $message, implode("\r\n", $headers));
}


