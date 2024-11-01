<?php
// Importers
require_once("../../controllers/core/HomeController.php");

// Instancia de controlador
$homeController = new HomeController;

// Rol del usuario
$rolFromUser = $homeController->rolFromUser();
?>
<header class="header">
    <nav class="navbar">
        <a href="../../views/core/home.php">
            <img src="../../assets/images/logo.webp" class="logo-header" alt="Logo" />
        </a>
        <form method="POST" action="../../controllers/auth/LogoutController.php">
            <button type="submit" class="logoutbtn">
                <img src="../../assets/icons/LogoutIcon.svg" />
            </button>
        </form>
    </nav>
</header>