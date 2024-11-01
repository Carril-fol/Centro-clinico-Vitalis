<?php
require '../../models/User.php';
require '../core/Controller.php';

class LoginController extends Controller
{
    private $userModel;
    public $dni;
    public $password;

    function __construct()
    {
        $this->userModel = new User;
        $this->dni = $_POST['dni'];
        $this->password = $_POST['password'];
    }

    private function verifyCredentials($dni, $password)
    {
        $userDataLogin = $this->userModel->getDniAndPasswordFromUserByDni($dni);
        if (!password_verify($password, $userDataLogin['contraseña'])) {
            throw new Exception("DNI o Contraseña incorrectos.");
        }
    }

    private function createCookieData($dataUser)
    {
        $timeExp = time() + 86400;
        $cookieData = array('data' => $dataUser, 'exp' => $timeExp);
        setcookie('accessToken', json_encode($cookieData), $timeExp, "/");
    }

    private function createRolCookie($dni)
    {
        $userData = $this->userModel->getRolFromUserByDni($dni);
        if (!$userData) {
            throw new Exception("The entered user cannot be found.");
        }
        $timeExp = time() + 86400;
        $cookieData = array('data' => $userData['rol'], 'exp' => $timeExp);
        setcookie("userRol", json_encode($cookieData), $timeExp, "/");
    }

    private function redirectToHome()
    {
        header("Location: ../../views/core/home.php");
        exit();
    }

    public function authenticate()
    {
        try {
            $dni = $this->sanitizeInput($this->dni);
            $password = $this->sanitizeInput($this->password);
            $this->verifyCredentials($dni, $password);

            $userDataLogged = $this->userModel->getDataFromUserByDni($dni);
            $this->createCookieData($userDataLogged);
            $this->createRolCookie($this->dni);
            $this->redirectToHome();
        } catch (Exception $error) {
            $this->handleError($error, 'auth', 'login');
        }
    }
}

$loginController = new LoginController;
$loginController->authenticate();
