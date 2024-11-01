<?php
require_once("../../controllers/core/HomeController.php");

$homeController = new HomeController();

$homeController->hasAccessTokenInCookies();

$rol = $homeController->rolFromUser();
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
    <?php include("../../components/common/headerLogged.php"); ?>
    <section class="seccion-home">
        <div class="container-table">
            <?php
            switch ($rol) {
                case "administrativo":
                    require_once("../../components/turns/table/TurnTableComponent.php");
                    break;
                case "médico":
                    require_once("../../components/turns/table/medics/TurnTableComponentMedic.php");
                    break;
                case "paciente":
                    break;
            }
            ?>
        </div>
    </section>
</body>
</html>
<script src="../../js/index.js"></script>