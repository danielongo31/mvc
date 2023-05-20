<?php

    class Auth extends BaseController
    {

        public function __construct()
        {
            parent::__construct();
        }

        public function render()
        {
            $this->view->render('Auth/index', [
                'variable' => 'Jose Luis Salinas',
                'variable2' => 'Hello view!',
                'variable3' => 123
            ]);
        }

    }

?>