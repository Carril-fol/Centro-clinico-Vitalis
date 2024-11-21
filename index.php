<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css\App.css">
    <link rel="shortcut icon" href="assets\images\logo.webp" type="image/x-icon">
    <title>Centro Clinico Vitalis</title>
</head>
<body>
    <?php
        include("components/landingPage/seccion-titulo.html");
        include("components/landingPage/seccion-que-hacemos.html");
        include("components/landingPage/seccion-comentarios.html");
        include("components/landingPage/seccion-nosotros.html");
        include("components/landingPage/seccion-contacto.html");
    ?>
</body>
</html>

<?php
    include("components/common/footer.html")
?>