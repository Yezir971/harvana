<?php
session_start();
require ("../class/Autoloader.php");
Autoloader::register();
// require ('../class/ConnexionAdmin.class.php');

$session = new Session();
$session->adminAccess();
$session->destroy();

$admin = new Admin();

$admin->insertTaux();
$admin->deleteAccount();
$title ="Admin : Harvana";

?>



<?php include('../inc/headAdmin.inc.php');?>

</head>
<body>

    <h1>Bienvenue sur la page Admin</h1>


    <form action = "#" method = "get">
        <input type = "search" placeholder="Recherche par e-mail" name = "terme">
        <input type = "submit" name = "s" value = "Rechercher / Réinitialiser">
    </form>
    <form action="#" method="post">
        <input type="submit" value="Déconnexion" name="decoSession">
    </form>
    <main>
        <table id="tableauUtilisateursAdmin">
            <?=$admin->affichePerso();?>
        </table>
    </main>

    <section>
        <h2 class="titreTaux">Taux de la semaine</h2>
        <table>
            <?=$admin->tauxAdmin();?>
        </table>
        <form action="#" method="post">
            <label for="taux">Taux de la semaine</label>
            <input type="text" name="taux">
            <input type="submit" value="Envoyer" name="insertButton">
        </form>
    </section>
<?php include('../inc/footerAdmin.inc.php'); ?>
