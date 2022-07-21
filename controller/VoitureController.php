<?php

    declare(strict_types = 1);

    namespace Vente_voiture_mvc\Controller;

    use Vente_voiture_mvc\Model\Voiture;

    class VoitureController
    {
        // attributs
        private $voiture;

        // constructeur
        public function __construct()
        {
            $this->voiture = new Voiture;
        }
        //--------------- Partie front ---------------------
        // méthodes
        // liste des voitures avec active à 1 (true)
        public function listeVoituresActives(): void
        {
            // ici c'est l'algo.
            $voitures = $this->voiture->allCarList();

            // on va chercher la vue pour lui donner la variable $voitures
            require_once('view/front/pageAccueil.php');
        }
        //--------------- Partie back-office----------------
        // méthodes
        // liste des voitures
    }