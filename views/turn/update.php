<?php
    // Importes
    include("../../controllers/core/HomeController.php");

    // Instancia de controlador
    $homeController = new HomeController();

    // Llamado de función del controlador
    $homeController->hasAccessTokenInCookies();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centro Clinico Vitalis</title>
    <link rel="stylesheet" href="../../css/App.css">
    <link rel="stylesheet" href="../../css/turn/Turn.css">
    <link rel="shortcut icon" href="../../assets/images/logo.webp" type="image/x-icon"></title></head>
<body>
    <?php include("../../components/common/headerLogged.html"); ?>
    <section class="section-turn">
        <div>
            <?php $homeController->errorInSession(); ?>
            <?php include("../../components/turns/forms/TurnFormUpdateComponent.php"); ?>
        </div>
    </section>
</body>
</html>