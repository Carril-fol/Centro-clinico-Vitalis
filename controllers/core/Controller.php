<?php

class Controller
{

    public function sanitizeInput($input)
    {
        return htmlentities(addslashes($input));
    }

    public function handleError($error, $folder, $file)
    {
        session_start();
        $_SESSION['error'] = $error->getMessage();
        header("Location: ../../views/" . $folder . "/" . $file . ".php");
        exit();
    }

    private function sanitizeUrl($url)
    {
        return parse_url($url);
    }

    public function getParamsUrl($url)
    {
        $urlParsed = $this->sanitizeURL($url);
        $queryParams = [];
        if (isset($urlParsed['query'])) {
            parse_str($urlParsed['query'], $queryParams);
        }
        return $queryParams;
    }

    public function getActionInUrl()
    {
        $url = $_SERVER['REQUEST_URI'];
        $queryParams = $this->getParamsUrl($url);
        if (isset($queryParams['action'])) {
            $action = $queryParams['action'];
        } else {
            $action = null;
        }
        return $action;
    }

    public function getIdUrl()
    {
        $url = $_SERVER['REQUEST_URI'];
        $id = $this->getParamsUrl($url)['id'];
        return $id;
    }

    public function errorInSession()
    {
        session_start();
        if (isset($_SESSION['error'])) {
            echo "<div class='error-msg' ><h2>Error</h2>" . "<p>" . $_SESSION['error'].  "</p>" . "</div>";
            unset($_SESSION['error']);
        }
    }

    public function getDniFromToken()
    {
        $dataInToken = json_decode($_COOKIE['accessToken'], true)['data'];
        return $dataInToken['dni'];
    }

    public function redirectToHome()
    {
        header("Location: ../../views/core/home.php");
        exit();
    }
}
