<?php
require_once('../controller/functions.php');
// Récuperer $key
if (!empty($_GET)) {
    if (isset($_GET['key'])) {
        $key = $_GET['key'];
    }
}
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
    <title>Changez votre mot de passe</title>
    <link rel="stylesheet" href="../public/style.css">
</head>
<body>
    <div class="center">
        <form action="../model/updatepassword.php" class="center" method="post">
            <div>
                <label for="mail">Votre email</label>
                <label for="psw">Nouveau mot de passe</label>
                <label for="confirm-psw">Confirmer mot de passe</label>
            </div>
            <div>
                <input type="hidden" name="key" id="key" value="<?php echo $key; ?>">
                <input type="email" name="email" id="email">
                <input type="password" name="psw" id="psw">
                <input type="password" name="confirm_psw" id="confirm_psw">
                <input type="submit" value="Envoyer">
                <?php echo $errorMsg; ?>
            </div>  
        </form>
    </div>
</body>
</html>