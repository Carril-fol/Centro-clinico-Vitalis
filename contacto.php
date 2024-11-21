<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'components/PHPMailer/Exception.php';
require 'components/PHPMailer/PHPMailer.php';
require 'components/PHPMailer/SMTP.php';

function correoConfirmacion() {
    $mail = new PHPMailer(true);

    $clienteNombre =  $_POST['Nombre'];
    $correoEnviador = 'pruebas.zekki@gmail.com';
    $contraseñaEnviador = 'mohkfnsntfxukfgx';
    try {
        //Configuraciones
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = $correoEnviador;
        $mail->Password   = $contraseñaEnviador;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
        $mail->Port       = 465;

        //Enviado y Receptor
        $mail->setFrom($correoEnviador, 'Centro Clinico Veritas');
        $mail->addAddress($_POST['correo']);

        //Contenido
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';   
        $mail->Subject = 'Centro Clinico Vitalis';
        $message = "
                    <html>
                    <head>
                        <title>Hola $clienteNombre Vitalis</title>
                    </head>
                    <body>
                        <h2>Hola, $clienteNombre!</h2>
                        <h3>Gracias por comunicarte, pronto te contactaremos.</h3>
                    </body>
                    </html>
                    ";
        $mail->Body    = $message;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

function correoPropio() {
    $mail = new PHPMailer(true);

    $mensaje = $_POST['mensaje'];
    $clienteNombre =  $_POST['nombre'];
    $clienteCorreo = $_POST['correo'];
    $correoEnviador = 'pruebas.zekki@gmail.com';
    $contraseñaEnviador = 'mohkfnsntfxukfgx';
    try {
        //Configuraciones
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = $correoEnviador;
        $mail->Password   = $contraseñaEnviador;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
        $mail->Port       = 465;

        //Enviado y Receptor
        $mail->setFrom($correoEnviador, 'Centro Clinico Veritas');
        $mail->addAddress($correoEnviador);

        //Contenido
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';   
        $mail->Subject = 'Se comunicaron';
        $message = "
                    <html>
                    <head>
                        <title>Mensaje:</title>
                    </head>
                    <body>
                        <h2>$clienteNombre : $clienteCorreo</h2>
                        <h3>$mensaje.</h3>
                    </body>
                    </html>
                    ";
        $mail->Body    = $message;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        header(header: "Location: index.php");   
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validación de los campos
    if (!empty($_POST['nombre']) && !empty($_POST['correo']) && !empty($_POST['mensaje'])) {
        correoConfirmacion();
        correoPropio();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e9f4fc;
            color: #333;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        h1 {
            text-align: center;
            color: #2a6ebb;
        }

        form {
            width: 100%;
            max-width: 500px;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
            color: #2a6ebb;
            display: block;
            margin-bottom: 8px;
        }

        input, textarea, button {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }

        input[type="text"], input[type="email"] {
            background-color: #f0f8ff;
        }

        textarea {
            background-color: #f0f8ff;
        }

        button {
            background-color: #4c91f0;
            color: white;
            border: none;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #3576d3;}
    </style>
</head>
<body>
    <h1>Formulario de Contacto</h1>
    <form action="<?php echo htmlentities($_SERVER['PHP_SELF'])?>" method="POST">
        <label for="nombre">Nombre:</label><br>
        <input type="text" id="nombre" name="nombre" required><br><br>
        
        <label for="correo">Correo:</label><br>
        <input type="email" id="correo" name="correo" required><br><br>
        
        <label for="mensaje">Mensaje:</label><br>
        <textarea id="mensaje" name="mensaje" rows="5" required></textarea><br><br>
        
        <button type="submit">Enviar</button>
    </form>
</body>
</html>