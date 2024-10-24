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
    <link rel="stylesheet" href="../../css/core/Core.css">
    <link rel="shortcut icon" href="../../assets/images/logo.webp" type="image/x-icon">
</head>
<body>
    <?php include("../../components/common/headerLogged.html"); ?>
    <section class="seccion-home">
        <div class="container-table">
            <?php require_once("../../components/turns/table/TurnTableComponent.php"); ?>
        </div>
    </section>
</body>
</html>