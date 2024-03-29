<?php
session_start();
require ("./assets/class/Autoloader.php");
Autoloader::register();

$session = new Session();
$session->visibility();
$session->destroyHebdo();

$info = new Hebdo();
$title ="Hebdomadaire : Harvana";
// var_dump($_SESSION);


?>



<?php include('assets/inc/head.inc.php');?>

</head>
<body>

    <h1>Bienvenue sur la page hebdomadaire <?= $session->get_info('firstname')?></h1>
    <form action="#" method="post">
        <input type="submit" value="Déconnexion" name="decoSession">
    </form>
    <table>
        <tr>
            <th>taux</th>
            <th>date</th>
        </tr>
        <?php $info->taux() ;?>
        

    </table>

    <?php include('assets/inc/footer.inc.php'); ?>
