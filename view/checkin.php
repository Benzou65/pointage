<?php
require_once('../controller/functions.php');
session_start();
// Gestion de l'heure été hiver
date_default_timezone_set('Europe/Paris');
setlocale (LC_TIME, 'fr_FR.utf8','fra');

// Vérification des erreurs
$errorMsg = "";
if (!empty($_GET['error']))
{
    if(isset($_GET['error']))
    {
        $errorMsg = displayError($_GET['error']);
    }
}

// Verif que la id de session existe
if (!empty($_SESSION['id'])) {
    if (isset($_SESSION['id']))
    {
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <!-- <link rel="stylesheet" href="../public/style.css"> -->
            <link rel="stylesheet" href="../public/css/bootstrap.min.css">
            <title>Document</title>
        </head>
        <body>
            <div class="container-md">
                <header class="text-center">
                    <h1 class="text-center">Vérification présences</h1>
                    <span>Bonjour les Nakamarc, nous sommes le <?php echo strftime('%A %d %B %Y') ?> et il est <?php echo strftime('%Hh%M.') ?></span>
                    <form action="../controller/logout.php" method="post" style="display: inline">
                    <input type="submit" value="Déconnexion" class="btn btn-secondary m-2">
                    </form>
                    <form action="../model/time_recording.php" method="post">
                    <label for="morning">Cliquez pour</label><input name="pointage" type="submit" value="pointer !" class="btn btn-primary m-2">
                    <?php
                        if (!empty($errorMsg)) {
                            echo "<span class='alert alert-danger m-2' role='alert'>" . $errorMsg . "</span>";
                        } ?>
                    </form>
                </header>
                <hr/>
                <div>
                    <table class="table table-striped table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Prénom</th>
                                <th scope="col">Nom</th>
                                <th scope="col">Matin</th>
                                <th scope="col">Après-midi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                require_once('../model/displaystudenttable.php');
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <script src="../public/js/bootstrap.js.map"></script>
        </body>
        </html>
        <?php
    }
}
else {
    header("Location: ./404.php");
}