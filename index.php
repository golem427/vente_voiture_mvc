<?php
    // on appelle le code de configuration config.php
    require_once('./config/config.php');
    // on appelle le code du router
    require_once('./core/Router.php');

    // instanciation de la classe Router
    $construitRoute = new Router;
    // on lance sa méthode public construitLaRoute()
    $construitRoute->construitLaRoute();