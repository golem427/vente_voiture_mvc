<?php
    declare(strict_types=1);

    namespace Voiture1\Model;

    USE Vente_voiture_mvc\Controller;
    use PDO;



    class ConnexionController
    {
        // déclaration des attributs
        private $id_membre;
        private $nom;
        private $email;
        private $password;
        private $role;
        // notre connexion
        private $cBdd;

        public function __construct()
        {
            // initialisation de l'attribut $cBdd
            $this->cBdd = new ConnexionController;
        }

        // les méthodes
        // --------------partie front---------------
        // création d'un membre pour gérer l'inscription
        public function createOneMember($post): void
        {
            // si l'adresse email n'existe pas en bdd, on crée le compte
            // utilisateur sinon on renvoie un message d'information
            // comme quoi le compte existe déjà.
            // récupération de l'email et reformatage
            // on rajoute des '' (avec addslashes()) et on retire les espace devant
            // et derrière l'email (avec trim())
            $this->email = addslashes(trim($post['email']));
            // on transforme l'email en minuscule
            $minusculeEmail = strtolower($this->email);
            // voir si cette email existe
            // 1- ecriture SQL
            $sql = "SELECT COUNT(*)
                    FROM membre
                    WHERE email = '$minusculeEmail'
                    ";
            // 2- préparation requête
            $query = $this->cBdd->connexion->query($sql);
            // 3- retour
            $retourQuery = $query->fetchColumn();
            // analyse de $retourQuery qui sera un entier
            if($retourQuery == 0):
                // on peut inscrire la personne
                // 1- prépa. de ce qui va être enregistrer en bdd
                $this->nom = addslashes(trim(ucfirst($post['nom'])));
                // déclaration $options qui sert pour l'encodage du password
                $options = ['cost' => 12];
                // encodage du password
                $this->password = password_hash(trim($post['password']), PASSWORD_DEFAULT, $options);
                // on va décider que 2 est le role utilisateur qui n'aura pas accès au back-office
                $this->role = 2;
                // 2- écriture SQL
                $sql = 'INSERT INTO membre(nom, email, password, role)
                        VALUE (:nom, :email, :password, :role)
                        ';
                // 3- prépa requête
                $query = $this->cBdd->connexion->prepare($sql);
                // afin d'éviter de répéter les bin Param, on va créer un tableau de donnée
                $datas = [
                            ':nom'      =>  $this->nom,
                            ':email'    =>  $this->email,
                            'password'  =>  $this->password,
                            ':role'     =>  $this->role
                ];
                // 4- on execute la requête avec $datas en argument
                $query->execute($datas);
                // 5- envoyer un message flash d'information
                $_SESSION['message'] = "Félicitation !! vous avez crée votre compte";
                // 6- redirection vers la page d'accueil (tjrs mettre exit() après un header())
                header("Location:/voiture1");
                exit();
            else:
                // on renvoie un message flash d'information d'erreur
                $_SESSION['message'] = "cet utilisateur existe déjà, veuillez choisir un autre email !!!";
                header("Location:/voiture1/inscription");
                exit();
            endif;
        }

        // Se connecter
        public function logIn($post): void
        {
            // récup. email
            $this->email = addslashes(trim($post['email']));
            $minusculeEmail = strtolower($this->email);
            $sql = "SELECT COUNT(*)
                    FROM membre
                    WHERE email = '$minusculeEmail'
                    ";
            $query = $this->cBdd->connexion->query($sql);
            $count = $query->fetchColumn();
            if($count == 1):
                $sql = "SELECT *
                        FROM membre
                        WHERE email = '$minusculeEmail'
                        ";
                $query = $this->cBdd->connexion->query($sql);
                // PDO:FETCH_ASSOC retourne un tableau associatif
                $membre = $query->fetch(PDO::FETCH_ASSOC);
                // vérification du mot de passe
                if(password_verify(trim($post['passeword']), $membre['password'])):
                    // on décide que 1 est le role admin et 2 utilisateur
                    // vérification du role
                    if($membre['role'] == 1):
                        // on rempli $_SESSION
                        $_SESSION['admin'] = true;
                        $_SESSION['nom'] = $membre['nom'];
                        $_SESSION['id_membre'] = $membre['id_membre'];
                        $_SESSION['isLog'] = true;
                        // on renvoie un message flash d'information
                        $_SESSION['message'] = "Vous êtes connecté !!";
                        header("Location:/voiture1");
                        exit();
                    else:
                        // on sécurise l'accès au chemin admin
                        $_SESSION['admin'] = false;
                        $_SESSION['nom'] = $membre['nom'];
                        $_SESSION['id_membre'] = $membre['id_membre'];
                        $_SESSION['isLog'] = true;
                        // on renvoie un message flash d'information
                        $_SESSION['message'] = "Vous êtes connecté !!";
                        header("Location:/voiture1");
                        exit();
                    endif;
                else:
                    $_SESSION['message'] = "Erreur de mot de passe !!!";
                    header('Location:/voiture1/seConnecter');
                    exit();
                endif;
            else:
                $_SESSION['message'] = "Désolé, utilisateur non identifié !!!";
                header('Location:/voiture1/seConnecter');
                exit();
            endif;
        }

    }