<?php
include_once "../../controllers/core/HomeController.php";

$homeController = new HomeController();

$homeController->hasAccessTokenInCookies();
$rolUser = $homeController->rolFromUser();
$validRolUser = $homeController->redirectIfRolFromUserIsNotValid($rolUser, "paciente");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centro Clinico Vitalis</title>
    <link rel="stylesheet" href="../../css/App.css">
    <link rel="stylesheet" href="../../css/turn/Turn.css">
    <link rel="stylesheet" href="../../css/core/Core.css">
    <link rel="shortcut icon" href="../../assets/images/logo.webp" type="image/x-icon">
    </title>
</head>
<body>
    <?php include "../../components/common/headerLogged.php"; ?>
    <section class="section-turn">
        <div>
            <?php include "../../components/patient/form/TurnFormComponentPatient.php"; ?>
        </div>
    </section>
</body>
</html>