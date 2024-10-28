<?php
    require '../core/Controller.php';

    class LogoutController extends Controller {
    
        private function redirectToLogin() {
            header("Location: ../../views/auth/login.php");
            exit();
        }

        private function isTokenInCookies() {
            if (!isset($_COOKIE['accessToken'])) {
                throw new Exception("No se encuentra el token de acceso en la COOKIES");
            }
            return true;
        }

        public function deleteCookie() {
            try {
                $this->isTokenInCookies();
                setcookie("accessToken", '', time() - 1, "/");
                $this->redirectToLogin();
            } catch (Exception $error) {
                $this->handleError($error, "auth", "login");
            }
        }
    

    }

    $logoutController = new LogoutController();
    $logoutController->deleteCookie();
?>