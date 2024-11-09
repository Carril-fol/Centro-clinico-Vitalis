<?php
// Importes
require '../../config.php';
require '../../models/User.php';

// Instancia de modelo de usuario
$userModel = new User;

try {
    $firstName = htmlentities(addslashes(strtoupper($_POST['firstName'])));
    $lastName = htmlentities(addslashes(strtoupper($_POST['lastName'])));
    $occupation = strtoupper($_POST['occupation']);
    $dni = htmlentities(addslashes($_POST['dni']));
    $email = strtolower($_POST['email']);
    $password = htmlentities(addslashes($_POST['password']));
    $confirmPassword = htmlentities(addslashes($_POST['confirmPassword']));

    if ($password != $confirmPassword) {
        throw new Exception('Las contraseñas no son iguales.');
    }
    $passwordHashed = password_hash($confirmPassword, PASSWORD_DEFAULT);

    $userCreated = $userModel->createUser($dni, $firstName, $lastName, $email, $passwordHashed, false, false);
    if (!$userCreated) {
        throw new Exception('Error al crear el usuario.');
    }

    $userModel->enviarCorreoBienvenida($email, $firstName);
    $getUserCreated = $userModel->getDataFromUserByDni($dni);

    switch ($occupation) {
        case 'ADMINISTRATIVO':
            require_once '../../models/Administrative.php';
            $administrativeModel = new Administrative;
            $administrativeModel->createAdministrative($dni);
            break;
        case 'MEDICO':
            require_once '../../models/Medic.php';
            $medicModel = new Medic;
            $medicLicense = htmlentities(addslashes(strtoupper($_POST['medicLicense'])));
            $medicSpeciality = htmlentities(addslashes(strtoupper($_POST['specialty'])));
            $medicModel->createMedic(
                $dni,
                $medicLicense,
                $medicSpeciality
            );
            break;
        case 'PACIENTE':
            require_once '../../models/Patient.php';
            $patientModel = new Patient;
            $patientModel->createPatient($dni);
            break;
    }
    exit();
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    $mensajeErr = $e->getMessage();
    echo "<script language='javascript'>alert('$mensajeErr');window.location.href = '../../views/auth/register.php';</script>";
    exit();
}

?>