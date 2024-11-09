<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once  __DIR__ . '/../config.php';

require '../../components/PHPMailer/Exception.php';
require '../../components/PHPMailer/PHPMailer.php';
require '../../components/PHPMailer/SMTP.php';

class User
{
    private $db;

    public function __construct() {
        $this->db = (new Database())->connection();
    }

    private function checkIfUserExists($dni)
    {
        $paramsQuery = [':dni'=>$dni];
        $selectQuery = "SELECT dni FROM usuario WHERE dni = :dni";
        $resultQuery = $this->db->prepare($selectQuery);
        $resultQuery->execute($paramsQuery);
        return $resultQuery->rowCount() > 0;
    }

    public function createUser($dni, $firstName, $lastName, $email, $password, $isSuperUser, $isStaff){   
        $existsUser = $this->checkIfUserExists($dni);
        if ($existsUser) {
            return false;
        }
        $paramsQuery = [
            ":dni" => $dni, 
            ":firstName" => $firstName, 
            ":lastName" => $lastName, 
            ":email" => $email, 
            ":password" => $password,
            ":isSuperUser" => $isSuperUser,
            ":isStaff" => $isStaff
        ];
        $insertQuery = "INSERT INTO usuario (dni, nombre, apellido, email, contraseña, estado, esSuperUsuario, esStaff) 
            VALUES (:dni, :firstName, :lastName, :email, :password, 'ALTA', :isSuperUser, :isStaff)";

        $resultQuery = $this->db->prepare($insertQuery);
        $result = $resultQuery->execute($paramsQuery);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function getDniAndPasswordFromUserByDni($dni){   
        $paramsQuery = [":dni"=>$dni];
        $selectQuery = "SELECT dni, contraseña FROM usuario WHERE dni = :dni";
        $resultQuery = $this->db->prepare($selectQuery);
        $resultQuery->execute($paramsQuery);
        $row = $resultQuery->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function getDataFromUserByDni($dni)
    {
        $paramsQuery = [':dni'=>$dni];
        $selectQuery = "SELECT id, dni, nombre, apellido, email FROM usuario WHERE dni = :dni";
        $resultQuery = $this->db->prepare($selectQuery);
        $resultQuery->execute($paramsQuery);
        $row = $resultQuery->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function getRolFromUserByDni($dni) {
        $paramsQuery = [':dni'=>$dni];
        $selectQuery = "SELECT 
            u.dni,
            CASE 
                WHEN a.dni IS NOT NULL THEN 'Administrativo'
                WHEN m.dni IS NOT NULL THEN 'Médico'
                WHEN p.dni IS NOT NULL THEN 'Paciente'
                ELSE 'No encontrado'
            END AS rol
        FROM 
            Usuario u
        LEFT JOIN 
            Administrativo a ON u.dni = a.dni
        LEFT JOIN 
            Medico m ON u.dni = m.dni
        LEFT JOIN 
            Paciente p ON u.dni = p.dni
        WHERE 
            u.dni = :dni";
        $resultQuery = $this->db->prepare($selectQuery);
        $resultQuery->execute($paramsQuery);
        $row = $resultQuery->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    public function enviarCorreoBienvenida($clienteEmail, $clienteNombre) {
        $mail = new PHPMailer(true);

        $correoEnviador = 'pruebas.zekki@gmail.com';
        $contraseñaEnviador = 'mohkfnsntfxukfgx';
        try {
            //Configuraciones
            $mail->SMTPDebug = 0;
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = $correoEnviador;                     //SMTP username
            $mail->Password   = $contraseñaEnviador;                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Enviado y Receptor
            $mail->setFrom($correoEnviador, 'Centro Clinico Veritas');
            $mail->addAddress($clienteEmail);     //Add a recipient

            //Contenido
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->CharSet = 'UTF-8';   
            $mail->Subject = 'Bienvenido a Centro Clinico Vitalis';
            $message = "
                        <html>
                        <head>
                            <title>Bienvenido a Centro Clinico Vitalis</title>
                        </head>
                        <body>
                            <h2>Hola, $clienteNombre!</h2>
                            <h3>Gracias por registrarte en nuestro sistema. Estamos encantados de tenerte con nosotros.</h3>
                        </body>
                        </html>
                        ";
            $mail->Body    = $message;
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            header(header: "Location: ../../views/core/confirm.php");   
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}

?>