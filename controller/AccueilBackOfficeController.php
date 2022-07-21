<?php
    declare(strict_types = 1);

    namespace Vente_voiture_mvc\Controller;

    class AccueilBackOfficeController
    {
        // aucun attrinut

        // constructeur
        public function __construct()
        {

        }

        // méthode de sécurité du back-office
        public function securiteAccueilBackOffice()
        {
            // on vérifie l'index 'admin' est bien à true dans $_SESSION
            if($_SESSION['admin'] == true):
                // si admin est vrais, on appelle la vue page d'accueil du back-office
                require_once('view/admin/pageAccueilBackOffice.php');
            else:
                $_SESSION['message'] = "Vous n'avez pas les droits d'administration.";
                header('Location:/vente-voiture-mvc');
                exit();
            endif;
        }
    }