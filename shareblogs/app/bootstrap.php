<?php
    //load config
    require_once 'config/config.php';

    //load helper
    require_once 'helpers/session_helper.php';

    //Auto load core libraries
    spl_autoload_register(function($className){
        require_once 'libraries/' . $className . '.php';
    });
?>