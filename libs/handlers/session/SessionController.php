<?php

    require_once 'libs/handlers/session/Session.php';
    require_once 'core/User.php';

    class SessionController extends BaseController {
        
        private $session;
        private $sites;
        private $defaultSites;

        private User $user;

        public function __construct()
        {
            parent::__construct();

            $this->user = new User();
            
            $this->init();
        }

        private function init()
        {
            $this->session = new Session();

            $json = $this->getJSONFile();

            $this->sites = $json["sites"];
            $this->defaultSites = $json["default-sites"];

            $this->validateSession();
        }

        private function getJSONFile() : array
        {
            $s = file_get_contents('config/access.json');
            $json = json_decode($s, true);

            return $json;
        }

        public function validateSession()
        {
            if ($this->existsSession()){
                $this->view->setUsername($this->getUserSessionData()->getUsername());
                $role = $this->getUserSessionData()->getRole()->getName();

                if ($this->isPublic()){
                    $this->redirectDefaultSiteByRole($role);
                } else {
                    if ($this->isAuthorized($role)){
                        
                    } else {
                        $this->redirectDefaultSiteByRole($role);
                    }
                }
            } else {
                if ($this->isPublic()){

                } else {
                    $this->redirect("", []);
                }
            }
        }

        public function existsSession() : bool
        {

            if (!$this->session->exists()){
                return false;
            }

            if ($this->session->getCurrentUser() == null){
                return false;
            }

            $account = $this->session->getCurrentUser();

            if ($account){
                return true;
            } else {
                return false;
            }
        }

        public function getUserSessionData() : User
        {
            $email = $this->session->getCurrentUser();
            $this->user = new User();

            if ($email != null) {
                $this->user->getByEmail($email);
            }

            return $this->user;
        }

        public function isPublic() : bool
        {
            $currentURL = $this->getCurrentPage();
            $currentURL = preg_replace("/\?.*/", "", $currentURL);

            for($i = 0; $i < sizeof($this->sites); $i++){
                if ($currentURL == $this->sites[$i]["site"] && $this->sites[$i]["access"] == "public"){
                    return true;
                }
            }

            return false;
        }

        public function getCurrentPage() : string
        {
            $actualLink = trim("$_SERVER[REQUEST_URI]");
            $url = explode("/", $actualLink);

            return $url[2];
        }

        private function redirectDefaultSiteByRole($role)
        {
            $url = "";

            for($i = 0; $i < sizeof($this->sites); $i++){
                if ($this->sites[$i]["role"] == $role){
                    $url =  $this->sites[$i]["site"];
                    break;
                }
            }

            header("Location: " . URL . $url, true, 302);
        }

        private function isAuthorized($role) : bool
        {
            $currentURL = $this->getCurrentPage();
            $currentURL = preg_replace("/\?.*/", "", $currentURL);

            for($i = 0; $i < sizeof($this->sites); $i++){
                if ($currentURL == $this->sites[$i]["site"] && $this->sites[$i]["role"] == $role){
                    return true;
                }
            }

            return false;
        }

        public function initialize(User $user)
        {
            $this->session->setCurrentUser($user);
            $this->authorizedAccess($user->getRole()->getName());
        }

        public function authorizedAccess(string $role)
        {
            switch($role){
                case "customer":
                    $this->redirect($this->defaultSites["customer"], []);
                    break;
                
                case "dev":
                    $this->redirect($this->defaultSites["dev"], []);
                    break;
            }
        }

        public function logout(){
            $this->session->closeSession(); //! FALTA
            $this->redirect("", []);
        }

        public function getAccount() : User { return $this->user; }
    }
