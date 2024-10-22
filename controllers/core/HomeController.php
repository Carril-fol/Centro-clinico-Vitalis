<?php
    // Importes
    require_once 'Controller.php';

    class HomeController extends Controller
    {

        public function hasAccessTokenInCookies() {
            try {
                $cookie = $_COOKIE["accessToken"];
                if (!isset($cookie)) {
                    throw new Exception("Tienes que iniciar sesión para poder accerder");
                }
                return true;
            } catch (Exception $error) {
                $this->handleError($error, 'auth', 'login');
            }
        }

    }
?>