<?php

    class Errores extends BaseController {

        function __construct()
        {
            parent::__construct();
            $this->view->render("Errores/index");
            error_log("Errores::Construct => Inicio de Errores");
        }
    }

?>