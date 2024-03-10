<?php
session_start();
require ("./assets/class/Autoloader.php");
Autoloader::register();

// $Bdd = new Bdd();
$sign = new Mdp();
$sign->mdpOk();

$title="Création de compte";

?>

<?php include('assets/inc/head.inc.php');?>
</head>
<body>
    <form action="#" method="post">
        <label for="firstname">Prénom</label>
        <input type="text" id="firstname" placeholder="Votre prénom" name="firstname">

        <label for="email">mail</label>
        <input id="email" type="email" placeholder="Votre mail" name="email">

        <label for="mdp">Mot de passe</label>
        <input name="mdp1" id="mdp" type="password" placeholder="Votre mot de passe">

        <label for="confirmMdp">Confirmer votre mot de passe</label>
        <input name="mdp2" id="confirmMdp" type="password" placeholder="Confirmer votre mot de passe">

        <input type="submit" value="S'inscire" name="signButton">
        <a href="login">Déja un compte ?</a>
    </form>

<?php include('assets/inc/footer.inc.php');?>
