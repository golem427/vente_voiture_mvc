<?php
    declare(strict_types = 1);

    namespace Vente_voiture_mvc\Controller;

    use PDO;

    // c'est la classe permettant de se connecter à la BDD

    class ConnexionController
    {
        // déclaration des attributs
        private $host;
        private $user;
        private $password;
        private $bdd;
        public $connexion;

        // le constructeur (il est toujours public)
        public function __construct()
        {
            // on détermine le jeu de variables de connexion à utiliser d'après la
            // configuration (!IS_ONLINE)

            // Les informations de base de données local
            if(!IS_ONLINE):
                $this->host = "localhost";
                $this->user = "root";
                // pour les MAC $this->password = "root"
                $this->password = "root";
                $this->bdd = "voiture1";
            else:
                // ici vous placerez les informations de la bdd données par l'hébergeur
                // (à remplir)
                $this->host = "";
                $this->user = "";
                $this->password = "";
                $this->bdd = "";
            endif;

            // connexion au serveur (en PDO qui est une classe native de PHP)
            // si la variable de connexion n'est pas définie
            if(!isset($this->connexion)):
                // essayer de ce connecter à la bdd avec les parametres de connexion en prenant
                // en charge les erreurs potentielles
                try{
                    $this->connexion = new PDO("mysql:host=$this->host; dbname=$this->bdd", $this->user, $this->password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
                    // cette requete(query) de connexion sera au format utf-8
                    $this->connexion->query("SET NAMES 'utf8'");
                // si une exception d'erreur de connexion survient, l'attraper
                }catch(\PDOException $exception){
                    // récupérer le message d'erreur et le code erreur à trvcers le classe native
                    // PDOexception ses méthodes getMessage() et getCode()
                    throw new \PDOException($exception->getMessage(), (int)$exception->getCode());
                }
            endif;
            return $this->connexion;
        }
    }

