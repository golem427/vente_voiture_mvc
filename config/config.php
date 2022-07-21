<?php
    // echo 'coucou';
    // on défini nos constantes globales de configuration
    // en PHPoo les bons usages veulent que les constantes globales soient nommées en
    // majuscule
    // renvoi quelque chose comme ...\vente-voiture-mvc
    $modiFILE = str_replace('\config', '',dirname(__FILE__));
    // var_dump($modiFILE);
    define('SITE_ROOT', $modiFILE);
    // echo SITE_ROOT;
    // déclaration du dossier de base de notre site
    define('BASE_FOLDER', '/vente-voiture-mvc');
    // déclaration de l'url d'accès à la racine du site, pour les MAC localhost:8888.
    define('SCRIPT_ROOT', 'http://localhost/vente-voiture-mvc');
    // déclaration du site en ligne ou pas
    // placer true à la place de false quand votre site est en ligne
    define('IS_ONLINE', false);

