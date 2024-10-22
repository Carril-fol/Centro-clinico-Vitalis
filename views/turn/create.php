<?php
    // Imports
    include("../../controllers/core/HomeController.php");

    $homeController = new HomeController();
    $homeController->hasAccessTokenInCookies();
    
    function errorInSession()
    {
        session_start();
        if (isset($_SESSION['error'])) {
            echo "<div style='color: red;'>Error: " . $_SESSION['error'] . "</div>";
            unset($_SESSION['error']);
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centro Clinico Vitalis</title>
    <link rel="stylesheet" href="../../css/App.css">
    <link rel="stylesheet" href="../../css/turn/Turn.css">
    <link rel="shortcut icon" href="../../assets/images/logo.webp" type="image/x-icon"></title>
</head>
<body>
    <?php include("../../components/common/headerLogged.html"); ?>
    <section class="section-turn">
        <div>
            <?php errorInSession(); ?>
            <?php include("../../components/turns/TurnFormComponentAdministrative.php"); ?>
        </div>
    </section>
    <?php include("../../components/common/footer.html"); ?>
</body>
</html>