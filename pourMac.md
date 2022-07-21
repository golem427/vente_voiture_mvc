<!--
si c'est un controller
            if(strpos($className, '\Controller')):
                $className = str_replace('Vente_voiture_mvc\\Controller\\', '', $className);
                $className = str_replace('\\', '/', $className);

                on declenche un require de ce fichier dans la structure physique du projet
                require SITE_ROOT . "/controller/".$className.".php";
            elseif(strpos($className, '\Model')):
                $className = str_replace('Vente_voiture_mvc\\Model\\', '', $className);
                $className = str_replace('\\', '/', $className);
                require SITE_ROOT . "/model/$className.php";
            endif;
 -->