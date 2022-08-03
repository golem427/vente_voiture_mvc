<?php
    declare(strict_types = 1);

    namespace Vente_voiture_mvc\Model;

    use PDO;
    use Vente_voiture_mvc\Controller\ConnexionController;

    // classe Membre représente la table membre de la bdd
    // au niveau des méthodes on va retrouver le CRUD + inscription + logIn + logOut
    // + listeDesMembres

    class Membre
    {
        // les attributs
        private $id_membre;
        private $nom;
        private $email;
        private $password;
        private $statut;
        // notre connexion
        private $cBdd;

        // le constructeur
        public function __construct()
        {
            // initialisation de l'attribut $cBdd
            $this->cBdd = new ModelConnexionController;
        }
        // les méthodes
        // Avant tout, il faut créer un membre qui soit administrateur pour pouvoir
        // configurer le back-office(partie admin)
        //---------------- partie front --------------------------------------
        // création d'un membre pour gérer l'inscription
        public function createOneMember($post): void
        {
            // si l'adresse n'existe pas en bdd, on crée le compte utilisateur sinon en renvoie
            // un message d'information comme quoi le compte existe déjà.
            // récupération et reformatage de l'email
            $this->email = addslashes(trim(ucfirst($post['email'])));
            $minusculeEmail = strtolower($this->email);
            // 1- écriture SQL
            $sql = "SELECT COUNT(*)
                    FROM membre
                    WHERE email = '$minusculeEmail'
                    ";
            // 2- Préparation requête
            $query = $this->cBdd->connexion->query($sql);
            $retourQuery = $query->fetchColumn();
            if($retourQuery == 0):
                // 1- préparation de ce qui va être enregistrer en bdd
                $this->nom = addslashes(trim(ucfirst($post['nom'])));
                // déclaration $option qui sert pour l'encodage du mot de passe
                $options = ['cost' => 12];
                $this->password = password_hash(trim($post['password']), PASSWORD_DEFAULT, $options);
                // on va décider que la valeur 2 est un membre utilisateur qui n'aura pas accès
                // au back-office (partie admin)
                $this->statut = 2;
                // 2- écriture SQL
                $sql = 'INSERT INTO membre(nom, email, password, statut)
                        VALUE (:nom, :email, :password, :statut)
                        ';
                // 3- prépa. requête
                $query = $this->cBdd->connexion->prepare($sql);
                // afin d'éviter de répéter les bin Param, on va créer un tableau de donnée que l'on
                // placera en paramêtre de execute($datas)
                $datas = [
                            ':nom'      =>  $this->nom,
                            ':email'    =>  $this->email,
                            ':password' =>  $this->password,
                            ':statut'   =>  $this->statut
                ];
                // 4- execute la requête
                $query->execute($datas);
                // 5- envoyer un message flash d'information
                $_SESSION['message'] = "Félicitation !! vous avez crée votre compte";
                // 6- redirection vers la page d'accueil
                header("Location:/vente-voiture-mvc");
                exit();
            else:
                // 5- on envoie un message flash d'information différent
                $_SESSION['message'] = "Cette utilisateur existe déjà, veuillez choisir un autre email, merci.";
                // 6- redirection vers l'inscription
                header("Location:/vente-voiture-mvc/inscription");
                exit();
            endif;
        }

        // méthode se connecter
        public function logIn($post): void
        {
            // récupération de l'email
            $this->email = addslashes(trim(ucfirst($post['email'])));
            $minusculeEmail = strtolower($this->email);
            // écriture sql
            $sql = "SELECT COUNT(*)
                    FROM membre
                    WHERE email = '$minusculeEmail'
                    ";
            // prépa réquête
            $query = $this->cBdd->connexion->query($sql);
            $count = $query->fetchColumn();
            if($count ==1):
                $sql = "SELECT *
                        FROM membre
                        WHERE email = '$minusculeEmail'
                ";
                $query = $this->cBdd->connexion->query($sql);
                // PDO::FETCH_ASSOC retourne un tableau associatif
                $membre = $query->fetch(PDO::FETCH_ASSOC);
                // vérification du mot de passe
                if(password_verify(trim($_POST['password']), $membre['password'])):
                // on décide que 1 est le stut admin et 2 utilisateur
                // vérification du statut
                    if($membre['statut'] == 1):
                        // on rempli $_SESSION
                        $_SESSION['admin'] = true;
                        $_SESSION['nom'] = $membre['nom'];
                        $_SESSION['isLog'] = true;
                        // on envoie un message flash d'information
                        $_SESSION['message'] = "Vous êtes bien connecté";
                        header("Location:/vente-voiture-mvc");
                        exit();
                    else:
                        // on sécurise l'accès au chemin admin
                        $_SESSION['admin'] = false;
                        $_SESSION['nom'] = $membre['nom'];
                        $_SESSION['isLog'] = true;
                        // on envoie un message flash d'information
                        $_SESSION['message'] = "Vous êtes bien connecté";
                    endif;
                    header("Location:/vente-voiture-mvc");
                    exit();
                else:
                    $_SESSION['message'] = "Erreur de mot de passe !!!";
                    header('Location:/vente-voiture-mvc/seConnecter');
                    exit();
                endif;
            else:
                $_SESSION['message'] = "Désolé, utilisateur non identifié !!!";
                header('Location:/vente-voiture-mvc/seConnecter');
                exit();
            endif;
        }

        // méthode logOut()
        public function logOut(): void
        {
            // on utilise la méthode native php ci-dessous pour detruire la session en cours
            session_destroy();
            // on redémarre un session vide
            session_start();
            $_SESSION['message'] = "Vous êtes déconnecté.";
            $_SESSION['isLog'] = false;
            header('Location:/vente-voiture-mvc');
            exit();
        }
        //--------------- partie back-office ---------------------------------
        // liste de tous les membres
        public function membersList()
        {
            $sql = 'SELECT *
                    FROM membre
                    ';
            $query = $this->cBdd->connexion->prepare($sql);
            $query->execute();

            $membres = $query->fetchAll(PDO::FETCH_OBJ);

            return $membres;
        }
        // détail d'un membre (Read)
        public function readOneMember($id_membre)
        {
            $this->id_membre = $id_membre;
            $sql = 'SELECT id_membre, nom, email, statut
                    FROM membre
                    WHERE id_membre = :id_membre
                    ';
            $query = $this->cBdd->connexion->prepare($sql);
            $datas = [
                ':id_membre'    => $this->id_membre
            ];
            $query->execute($datas);
            $readOneMember = $query->fetch(PDO::FETCH_OBJ);
            return $readOneMember;
        }
        // modifier un membre (Update)
        public function updateOneMember($id_membre, $post)
        {
            // on récupère l'id_membre
            $this->id_membre = $id_membre;
            // on récupère les données du formulaire de modification avec $_POST, à travers $post
            // dans notre cas $post = $_POST
            // récupération des différent name="..." du formulaire
            $this->nom = addslashes(trim(ucfirst($post['nom'])));
            $this->email = addslashes(trim(ucfirst($post['email'])));
            $this->statut = $post['statut'];

            $sql = 'UPDATE membre
                    SET     nom = :nom,
                            email = :email,
                            statut = :statut
                    WHERE   id_membre = :id_membre
                    ';
            $query = $this->cBdd->connexion->prepare($sql);
            $datas = [
                ':id_membre'        => $this->id_membre,
                ':nom'              => $this->nom,
                ':email'            => $this->email,
                ':statut'           => $this->statut
            ];
            $query->execute($datas);
            // message
            $_SESSION['message'] = "Cette utilisateur a été modifier.";
        }
        // supprimer un membre (Delete)
        public function deleteOneMember($id_membre)
        {
            // on récupère l'id_membre
            $this->id_membre =$id_membre;
            $sql = 'DELETE FROM membre
                    WHERE   id_membre = :id_membre
            ';
            $query = $this->cBdd->connexion->prepare($sql);
            $datas = [
                ':id_membre'    => $id_membre
            ];
            $query->execute($datas);
        }


    }