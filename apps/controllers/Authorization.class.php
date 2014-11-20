<?php

class Authorization extends BController {

    public function login() {
        if (isset($_POST['ulogin']) && isset($_POST['upass'])) {
            header('Location: /console/index');
        }
    }
    
    public function index() {
        echo 'ku!';
    }
}

?>