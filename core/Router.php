<?php

    declare(strict_types = 1);

    use Vente_voiture_mvc\Autoloader;
    use Vente_voiture_mvc\Controller\AccueilBackOfficeController;
    use Vente_voiture_mvc\Controller\MembreController;
    use Vente_voiture_mvc\Controller\VoitureController;

    // cette méthode native php permet d'initialiser la variable super globale de php
    // $_SESSION comme un tableau vide
    session_start();

    // on intègre le fichier de configuration
    require_once('./config/config.php');
    // ajoute l'autoloader dans le fichier
    require_once('./core/Autoloader.php');
    // on appelle la méthode statique register() de la classe Autoloader
    // pour rappel les méthodes statiques ne sont pas appellées avec -> mais avec ::
    Autoloader::register();

    // La classe Router (c'est un chemen, un route) :
    // - dans son constructeur : on va utiliser la méthode privée(donc encapsulé dans la classe
    // elle-même) rajouterUneRoute(avec des paaramètres) pour rajouter une route.
    // - on va avoir une méthode public construitLaRoute() qui sera lancée depuis le fichier
    // index.php, elle analyse le chemin(la route) dans la barre d'adresse du navigateur et
    // déclenche la méthode du contrôleur associé à la route.
    class Router
    {
        // on déclare un tableau associatif qui sera composé de la sorte :
        // $route[nomDeRoute] = fonction

        // attributs
        private $routes;
        // atribut pour mémorisé le contrôleur concerné par l'action
        private $currentController;

        // le constructeur : il va gérer le système de routage et analyser si la route demandée dans les
        // href des balises a href="..."></a correspond à une route existante et correctement configuré en
        // fonction de son niveau.

        public function __construct()
        {
            //-----------------gestion des routes à 1 niveau :-----------------------
            $this->rajouterUneRoute("/", function ($params) {
                $this->currentController = new VoitureController;
                $this->currentController->listeVoituresActives();
            });
            // gestion inscription
            // on décide de rajouter la route /inscription
            $this->rajouterUneRoute("/inscription", function($params){
                $this->currentController =new MembreController;
                $this->currentController->inscription();
            });
            // gestion connexion
            $this->rajouterUneRoute("/seConnecter", function($params){
                $this->currentController = new MembreController;
                $this->currentController->seConnecter();
            });
            // gestion déconnexion
            $this->rajouterUneRoute("/seDeconnecter", function($params){
                $this->currentController = new MembreController;
                $this->currentController->seDeconnecter();
            });
            //----------------gestion des routes à 2, 3 et 4 niveaux-----------------
            $this->rajouterUneRoute("/admin", function($params){
                // -------------- appelle sécurisation de l'url admin ---------------
                $this->securiteUrlAdmin($_GET);
                // ----------------------------------------------------------
                // on analyse la nature des données devant être pris en charge et donc
                // on en déduit le contrôleur qui va être impliqué
                // route 2ème niveau
                switch($params[0]):
                    case 'bienvenueAdmin':
                        $this->currentController = new AccueilBackOfficeController;
                        break;
                    case 'gestionDesMembres':
                        $this->currentController = new MembreController;
                        break;
                endswitch;
                // si pas de route après admin (niv.2)
                if(!isset($params[1])):
                    // par defaut
                    $params[1] = 'pageAccueilAdmin';
                endif;
                // on part dans un switch si le router voie une route de 3ème niveau
                switch($params[1]):
                    case 'pageAccueilAdmin':
                        // on déclenche la méthode securiteAccueilBackOffice()
                        $this->currentController->securiteAccueilBackOffice();
                        break;
                    case 'listeDesMembres':
                        $this->currentController->listeDesMembres();
                        break;
                    case 'voirUnMembre':
                        $this->currentController->voirUnMembre($params[2]);
                        break;
                    case 'modifierUnMembre':
                        $this->currentController->modifierUnMembre($params[2], $_POST);
                        break;
                    case 'supprimerUnMembre':
                        $this->currentController->supprimerUnMembre($params[2]);
                        break;
                endswitch;
            });
        }

        // méthodes
        // ----------------- sécurisation url admin ----------------------
        private function securiteUrlAdmin($get): void
        {
            // sécurisation url admin
            // $_GET nous renvois un tableau avec une clé path1 correspondant à
            // l'adresse en cours
            // on récupère la chaine de caractère à la clé path1 de $_GET
            $stringGet = $get['path1'];
            // on déclare la chaine à rechercher
            $admin = 'admin';
            // on recherche la présence de admin dans la chaine $stringGet
            $getAdmin = strpos($stringGet, $admin);
            // si admin est présent dans le résultat de la recherche
            if($getAdmin !== false):
                // si (l'index admin est définie dans la session et que admin est faux)
                // ou que l'index admin n'est pas définie dans la session
                if(((isset($_SESSION['admin']) && ($_SESSION['admin'] == false))) || (!isset($_SESSION['admin']))):
                    // on fait une redirection automatique vers la page d'accueil
                    header('Location:/vente-voiture-mvc');
                    exit();
                endif;
            endif;
        }

        private function rajouterUneRoute(string $route, callable $closure): void
        {
            $this->routes[$route] = $closure;
        }

        public function construitLaRoute(): void
        {
            // on récupère l'adresse demandée
            $chemin = $_SERVER['REQUEST_URI'];
            // echo '<pre>';
            //  var_dump($chemin);
            // echo '</pre>';
            // on cherche et remplace par du vide la constante globale BASE_FOLDER
            // dans le chemin récupéré dans la barre d'adresse.
            $cheminFinal = str_replace(BASE_FOLDER, "", $chemin);
            // Avec la méthode native PHP strrpos(), on cherche dans l'adresse retenue
            // ($cheminFinal) le caractère / pour déterminer si c'est une route
            // à plusieurs niveaux, comme par exemple /admin/voiture/listeVoiture qui
            // diffère avec une adresse de 1er niveau / ou /admin.
            $dernierIndex = strrpos($cheminFinal, '/');
            // on crée un  tableau $tableau qui recevra comme entrée les "arguments" de
            // la route, c'est à dire qui est après le 1er niveau voiture et listeVoiture
            // dans notre cas.
            $tableau = [];
            // si le $dernierIndex de /  est supérieur à 0 alors on est sur une route de plusieurs
            // niveaux
            if ($dernierIndex > 0):
                // on éclate la chaine de $cheminFinal à l'aide de la méthode native explode()
                $tableau2 = explode("/", $cheminFinal);
                // on met à jour le $cheminFinal.
                // Comme le tableau est de cette sorte pour l'adresse /admin/voiture/listeVoiture :
                // Array([0]=> [1] => admin [2] => voiture [3] => listeVoiture
                $cheminFinal = "/" . $tableau2[1];
                // on stocke les appelations des niveaux en dehors du 1er dans le tableau $tableau
                for ($i = 2; $i < count($tableau2); $i++):
                     // on met le mot issue de la route dans le tableau
                    array_push($tableau, $tableau2[$i]);
                endfor;
            endif;
            // on vérifie le chemin ($cheminFinal) si il existe dans le tableau des routes prises en
            // charge dans le MVC
            if (array_key_exists($cheminFinal, $this->routes)):
                $this->routes[$cheminFinal]($tableau);
            // sinon on affiche un message d'erreur 404.
            else:
                echo 'erreur 404 !!!!';
            endif;
        }
    }