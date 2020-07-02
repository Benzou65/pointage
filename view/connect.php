<?php
require_once('../controller/functions.php');
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
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../public/style.css">
    <title>Pointage</title>
</head>
<body>
    <div class="center">
        <form action="../controller/checkconnect.php" method="post" class="center">
            <div>
                <label for="email">E-mail</label>
                <label for="password">Mot de passe</label>
                <a href="../view/inscription.php">S'inscrire</a>
                <a href="../view/lostpassword.php">Récupérer son mot de passe</a>
            </div>
            <div>
                <input name="email" type="email">
                <input name="password" type="password">
                <input type="submit" value="Connexion">
                <?php echo $errorMsg; ?>
            </div> 
        </form>
    </div> 
</body>
</html>