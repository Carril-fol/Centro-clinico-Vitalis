<?php
    require '../../models/User.php';
    require '../core/Controller.php';

    class LoginController extends Controller
    {
        private $userModel;
        public $dni;
        public $password;

        function __construct() {
            $this->userModel = new User;
            $this->dni = $_POST['dni'];
            $this->password = $_POST['password'];
        }

        private function verifyCredentials($dni, $password) {
            $userDataLogin = $this->userModel->getDniAndPasswordFromUserByDni($dni);
            if (!password_verify($password, $userDataLogin['contraseña'])) {
                throw new Exception("DNI o Contraseña incorrectos.");
            }
        }

        private function redirectToHome() {
            header("Location: ../../views/core/home.php");
            exit();
        }
        public function authenticate() {
            try {
                $dni = $this->sanitizeInput($this->dni);
                $password = $this->sanitizeInput($this->password);
                
                $this->verifyCredentials($dni, $password);
    
                $userDataLogged = $this->userModel->getDataFromUserByDni($dni);
                $this->userModel->createCookieData($userDataLogged);
                
                $this->redirectToHome();
            } catch (Exception $error) {
                $this->handleError($error, 'auth', 'login');
            }
        }
    }
    
    $loginController = new LoginController;
    $loginController->authenticate();
?>