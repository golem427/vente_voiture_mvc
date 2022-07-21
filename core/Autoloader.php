<?php
    declare(strict_types = 1);

    namespace Vente_voiture_mvc;

    class Autoloader
    {
        // déclaration des méthodes
        static function register(): void
        {
            spl_autoload_register(array(__CLASS__, 'autoload'));
        }

        // la méthode remplace le namespace de la classe chargé et le remplace par le vrai
        // chemin(physique)
        static function autoload($className): void
        {
            // si c'est un contrôleur
            if(strpos($className, '\Controller')):

                $className = str_replace('Vente_voiture_mvc\\Controller\\', '', $className);
                // pour le MAC $className = str_replace('\\', '/', $className);
                // on déclenche un require de ce fichier dans la structure physique du projet
                // pour MAC : require SITE_ROOT . "/controller/".$className.".php"
                require SITE_ROOT . "\controller\\$className.php";
                elseif(strpos($className, '\Model')):
                    $className = str_replace('Vente_voiture_mvc\\Model\\', '', $className);
                    // pour le MAC $className = str_replace('\\', '/', $className);
                    
                    // pour MAC : require SITE_ROOT . "/model/".$className.".php"
                    require SITE_ROOT . "\model\\$className.php";
            endif;




            
        }
    }
    
