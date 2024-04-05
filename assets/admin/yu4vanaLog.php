<?php
session_start();

require ('../class/ConnexionAdmin.class.php');

$log = new ConnexionAdmin();
$log->verifierCompte();

$title ="Admin : Connexion Harvana";

?>

<?php include('../inc/headAdmin.inc.php');?>
</head>
<body>
    <h1>Connexion admin</h1>
    <form action="#" method="post">
        <label for="firstname">Prénom</label>
        <input type="text" id="firstname" placeholder="Votre prénom" name="firstname">

        <label for="email">Mail</label>
        <input type="email" id="email" placeholder="Votre mail" name="email">

        <label for="password">Mot de passe</label>
        <input type="password" id="password" name="mdp">

        <input type="submit" value="Se connecter" name="logButton">
    </form>

<?php include('../inc/footerAdmin.inc.php'); ?>
