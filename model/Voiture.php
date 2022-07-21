<?php
    declare(strict_types = 1);

    namespace Vente_voiture_mvc\Model;

    use PDO;
    use Vente_voiture_mvc\Controller\ConnexionController;

    class Voiture
    {
        // les attributs
        // on déclare un attribut pour chaque champ (colonne) de la table voiture
        private $nom;
        private $marque;
        private $couleur;
        private $image;
        private $prix;
        private $active;
        // on déclare également un attribut pour gérer le fichier physique de l'image
        private $fichierImage;
        // on déclare pour finir un attribut pour recevoir une instance de la classe
        // ConnexionController pour les transaction avec la bdd
        private $cBdd;

        // le constructeur (toujours public)
        public function __construct()
        {
            // on instancie la classe ConnexionController
            $this->cBdd = new ConnexionController;
        }

        // les méthodes
        //------------------front--------------------------
        public function allCarList()
        {
            // 1 préparation écriture requête SQL
            $sql = 'SELECT *
                    FROM voiture
                    ';
            // 2 préparation de la requête avec la connexion à la bdd
            $query = $this->cBdd->connexion->prepare($sql);

            // 3 lancement de la requête
            $query->execute();

            // retour de la requête que l'on place dans la variable $voitures
            $voitures = $query->fetchAll(PDO::FETCH_OBJ);
            return $voitures;
        }

        //------------------back-office ou admin-----------

    }