<?php
session_start();
require ("./assets/class/Autoloader.php");
Autoloader::register();

$log = new Connexion();







$title="Connexion harvana";

?>

<?php include('assets/inc/head.inc.php');?>
<?php include('assets/inc/header.inc.php');?>
</head>
<body>
    <form action="#" method="post">
        <label for="firstname">Prénom</label>
        <input type="text" id="firstname" placeholder="Votre prénom" name="firstname">

        <label for="email">Mail</label>
        <input type="email" id="email" placeholder="Votre mail" name="email">

        <label for="password">Mot de passe</label>
        <input type="password" id="password" name="mdp">

        <?php $log->verifierCompte(); ?>

        <input type="submit" value="Se connecter" name="logButton">
    </form>

<?php include('assets/inc/footer.inc.php'); ?>
