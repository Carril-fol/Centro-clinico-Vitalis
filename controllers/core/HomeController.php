<?php
// Importes
require_once 'Controller.php';

class HomeController extends Controller
{
    public function getRolFromUser()
    {
        $cookieRol = strtolower(json_decode($_COOKIE["userRol"], true)['data']);
        return $cookieRol;
    }

    public function validateRolFromUser($userRolInCookies, $userRolValid)
    {
        if ($userRolInCookies != $userRolValid) {
            header("Location: ../../views/core/home.php");
            exit();
        } else {
            return false;
        }
    }

    public function hasAccessTokenInCookies()
    {
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
