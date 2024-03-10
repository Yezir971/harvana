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
$title ="Admin : Harvana";

?>



<?php include('../inc/head.inc.php');?>

</head>
<body>

    <p>Bienvenue sur la page Admin</p>


    <form action = "#" method = "get">
        <input type = "search" name = "terme">
        <input type = "submit" name = "s" value = "Rechercher">
    </form>


    <form action="#" method="post">
        <input type="submit" value="Déconnexion" name="decoSession">
    </form>
    <main>
        <table>
        <?=$admin->affichePerso();?>
        </table>
    </main>
    <section>
        <form action="#" method="post">
            <label for="taux">Taux de la semaine</label>
            <input type="text" name="taux">
            <input type="submit" value="Envoyer" name="insertButton">
        </form>
    </section>
<?php include('../inc/footer.inc.php'); ?>
