<?php

    class Controller
    {

        public function sanitizeInput($input) {
            return htmlentities(addslashes($input));
        }

        public function handleError($error, $folder, $file) {
            session_start();
            $_SESSION['error'] = $error->getMessage();
            header("Location: ../../views/" . $folder . "/" . $file . ".php");
            exit();
        }

        private function sanitizeUrl($url) {
            $urlParsed = parse_url($url);
            return $urlParsed;
        } 

        public function getParamsUrl($url) {
            $urlParsed = $this->sanitizeURL($url);
            $queryParams = [];
            if (isset($urlParsed['query'])) {
                parse_str($urlParsed['query'], $queryParams);
            }
            return $queryParams;
        }

        public function getActionInUrl() {
            $url = $_SERVER['REQUEST_URI'];
            $queryParams = $this->getParamsUrl($url);
            if (isset($queryParams['action'])) {
                $action = $queryParams['action'];
            } else {
                $action = null;
            }
            return $action;
        }

        public function getIdUrl() {
            $url = $_SERVER['REQUEST_URI'];
            $id = $this->getParamsUrl($url)['id'];
            return $id;
        }

        public function errorInSession()
        {
            session_start();
            if (isset($_SESSION['error'])) {
                echo "<div style='color: red;'>Error: " . $_SESSION['error'] . "</div>";
                unset($_SESSION['error']);
            }
        }
    }

?>