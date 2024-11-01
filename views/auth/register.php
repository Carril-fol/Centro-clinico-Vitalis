<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centro Clinico Vitalis</title>
    <link rel="stylesheet" href="../../css/auth/Auth.css">
    <link rel="stylesheet" href="../../css/App.css">
    <link rel="stylesheet" href="../../css/core/Core.css">
    <link rel="shortcut icon" href="../../assets/images/logo.webp" type="image/x-icon">
</head>
<body>
    <?php include("../../components/common/headerLogged.php"); ?>
    <section class="section-formulario-alta">
        <form class="formulario-alta" action="../../controllers/auth/RegisterUsersController.php" method="POST">
            <div class="formulario-alta-logo-titulo">
                <img src="../../assets/images/logo.webp" alt="Logo" />
                <h1>Dar de alta</h1>
            </div>
            <input type="text" name="firstName" placeholder="Nombre" />
            <input type="text" name="lastName" placeholder="Apellido" />
            <input type="text" name="dni" placeholder="DNI"
                pattern="^\d{8}$"
                title="El DNI debe tener 8 dígitos."
                required />

            <select name="occupation" id="occupationSelect" required onchange="checkOccupation()">
                <option value="Seleccione una opcion">Seleccione una opcion</option>
                <option value="Medico">Medico</option>
                <option value="Administrativo">Administrativo</option>
                <option value="Paciente">Paciente</option>
            </select>

            <div id="additionalInputs">
            </div>

            <input type="email" name="email" placeholder="Email"
                pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$"
                title="Ingrese un correo electrónico válido."
                required />
            <input type="password" name="password" placeholder="Contraseña"
                pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$"
                title="La contraseña debe tener al menos 8 caracteres, incluyendo al menos una letra mayúscula, una letra minúscula, un número y un carácter especial."
                required />
            <input type="password" name="confirmPassword" placeholder="Confirmar contraseña"
                pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$"
                title="La confirmación de la contraseña debe coincidir con la contraseña original."
                required />
            <button type="submit">Dar de alta</button>
        </form>
    </section>
</body>
</html>
<script src="../../js/index.js"></script>