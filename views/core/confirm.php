<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuenta Creada</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f6f8;
        }
        .confirmacion-box {
            text-align: center;
            background-color: #ffffff;
            padding: 20px 40px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #2badc8;
            margin-bottom: 10px;
        }
        p {
            color: #555;
            margin-bottom: 20px;
        }
         .cargando {
            border: 5px solid #f3f3f3;
            border-top: 5px solid #2badc8;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: girar 1s linear infinite;
            margin: 0 auto;
        }
        @keyframes girar {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="confirmacion-box">
        <h1>¡Cuenta Creada!</h1>
        <p>Se envio un mensaje de Bienvenida a tu correo</p>
        <p>Tu cuenta ha sido creada exitosamente. Redirigiendo al inicio...</p>
         <div class="cargando"></div>
    </div>
</body>
</html>
<?php 
header("refresh:3; url=home.php");
?>