<?php
require_once  __DIR__ . '/../config.php';

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
        //Esta parte se tiene que cambiar por el correo de la empresa o un correo verdadro, para que no se lo detecte como posible spam o sea eliminado automaticamente
        $emailFrom = "no-reply@tu-dominio.com";

        $to = $clienteEmail;
        $subject = "Bienvenido a Centro Clinico Vitalis";
        $message = "
        <html>
        <head>
            <title>Bienvenido a Centro Clinico Vitalis</title>
        </head>
        <body>
            <h1>Hola, $clienteNombre!</h1>
            <p>Gracias por registrarte en nuestro sistema. Estamos encantados de tenerte con nosotros.</p>
        </body>
        </html>
        ";
    
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    
        $headers .= "From: $emailFrom" . "\r\n";

        $enviado = mail($to, $subject, $message, $headers);
        
// AL SUBIR EL CODIGO A LA WEB SE DEbERA BORRAR LA SIGUIENTE LINEA Y DESCOMENTAR LAS DEMAS. SE DEBERA ASEGURAR EL SERVIDOR WEB TIENE SOPORTE SMTP y CONFIGURADO PARA ENVIO DE CORREOS
        header(header: "Location: ../../views/core/confirm.php");
        // if($enviado) { 
        //     header(header: "Location: ../../views/core/confirm.php");
        // } else {
        //     echo "Error al enviar el mensaje";
        // }
    }
}

?>