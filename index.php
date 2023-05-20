<?php

    error_reporting(E_ALL); // Error/Exception engine, always use E_ALL

    ini_set("ignore_repeated_errors", TRUE); // Always use TRUE
    ini_set("display_errors", FALSE); // Error/Exception display, use FALSE only in production
    ini_set("log_errors", TRUE); // Error/Exception file logging engine
    ini_set("error_log", "C:/xampp\htdocs\mvc/php-error.log");

    error_log("Run App");

    //! LIBRARY
    require 'libs/base/App.php';
    require 'libs/base/BaseController.php';
    require 'libs/base/BaseModel.php';
    require 'libs/base/View.php';
    require 'libs/db/Db.php';

    require 'libs/handlers/messages/ErrorMessages.php';
    require 'libs/handlers/messages/SuccessMessages.php';
    require 'libs/handlers/session/SessionController.php';

    require 'config/settings.php';

    $app = new App();

?>