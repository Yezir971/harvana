<?php
session_start();
require ("./assets/class/Autoloader.php");
Autoloader::register();

// $Bdd = new Bdd();
$sign = new Mdp();

$title="Création de compte";
?>

<?php include('assets/inc/head.inc.php');?>
<?php include('assets/inc/header.inc.php');?>
</head>
<body>
    <div class="stockImg">
        <img id="imgSignUp" src="./assets/img/img_harvana_2.png" alt="representation de l'argent investis par les utilisateurs via les tradeurs qui gère la crypto monnaie">
        <h1>Investis dans ton futur avec Seven Liberty</h1>
    </div>

    <form action="" method="post">
        <label for="firstname">Prénom</label>
        <input type="text" id="firstname" placeholder="Votre prénom" name="firstname">

        <label for="email">mail</label>
        <input id="email" type="email" placeholder="Votre mail" name="email">

        <label for="mdp">Mot de passe</label>
        <input name="mdp1" id="mdp" type="password" placeholder="Votre mot de passe">
        
        
        <label for="confirmMdp">Confirmer votre mot de passe</label>
        <input name="mdp2" id="confirmMdp" type="password" placeholder="Confirmer votre mot de passe">
        <?php $sign->mdpOk(); ?>
        
        <input type="submit" value="S'INSCRIRE" name="signButton">
        <a href="login">Déja un compte ?</a>
    </form>
    

<?php include('assets/inc/footer.inc.php');?>
