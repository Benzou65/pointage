<?php
require_once('../controller/functions.php');
require_once('../model/getClass.php');
// Vérification des erreurs
$errorMsg = "";
if (!empty($_GET['error']))
{
    if(isset($_GET['error']))
    {
        $errorMsg = displayError($_GET['error']);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../public/style.css">
	<title>Inscription</title>
</head>
<body>
	<div class="center">
		<form action="../model/adduser.php" method="post" class="center">
			<div>
				<label for="prenom">Prénom</label>
				<label for="nom">Nom</label>
				<label for="classe">Classe</label>	
				<label for="email">E-mail</label>
				<label for="psw">Mot de passe</label>
				<label for="confirm_psw">Confirmer le mot de passe</label>
				<a href="../">Retour</a>
			</div>
			<div>
				<input type="text" name="prenom" minlength="2" maxlength="255" required>
				<input type="text" name="nom" minlength="2" maxlength="255" required>  <!-- minlength="2" maxlength="255" required -->
				<select name="classe">
					<option value="">Choisissez une classe</option>
					<?php
						foreach(getClass() as $class) {
							echo "<option value='" . htmlspecialchars($class) . "'>" . htmlspecialchars($class) . "</option>";
						}
					?>
				</select>
				<input type="email" name="email" minlength="6" maxlength="255" required>
				<input type="password" name="psw" id="password" minlength="6" maxlength="255" required>
				<input type="password" name="confirm_psw" id="confirm_password" minlength="6" maxlength="255" required>
				<input type="submit" value="S'inscrire"><br/>
				<?php echo $errorMsg; 
				getClass();
				?>
			</div>
		</form>
	</div>
</body>
</html>