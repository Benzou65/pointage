<?php
require_once('../controller/functions.php');
// Vérification des erreurs
$errorMsg = "";
if (!empty($_GET['error']))
{
    if(isset($_GET['error']) && isset($_GET['time']))
    {
        $errorMsg = displayError($_GET['error'],$_GET['time']);
    }
    elseif(isset($_GET['error']))
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
    <title>Mot de passe perdu ?</title>
</head>
<body>
    <div class="center">
        <form action="../controller/sendmailpassword.php" method="post" class="center">
            <div>
                <label for="email">E-mail</label>
                <a href="../">Retour</a>
            </div>
            <div>
                <input type="email" name="email" pattern="^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$" size="40" required>
                <input type="submit" value="Envoyer mail">
                <?php echo $errorMsg; ?>
            </div> 
        </form>
    </div> 
</body>
</html>