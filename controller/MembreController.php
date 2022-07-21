<?php
    declare(strict_types = 1);

    namespace Vente_voiture_mvc\Controller;

    use Vente_voiture_mvc\Model\Membre;

    class MembreController
    {
        // attribut
        private $membre;

        // constructeur
        public function __construct()
        {
            // création de l'objet $membre
            $this->membre = new Membre;
        }

        // méthodes
        // ----------------------partie front-------------------
        // gestion de l'inscription
        public function inscription(): void
        {
            // on construit notre logique de programmation
            if(isset($_POST['submit'])):
                $this->membre->createOneMember($_POST);
            endif;
            // on fait appelle à la vue
            require_once('view/front/inscription.php');
        }

        public function seConnecter(): void
        {
            // on construit notre logique
            if(isset($_POST['submit'])):
                $this->membre->logIn($_POST);
            endif;
            // la vue
            require_once('view/front/logIn.php');
        }

        public function seDeconnecter(): void
        {
            $this->membre->logOut();
        }

        //--------------------- partie back-office --------------------
        // -----------gestion des membres------------
        // récup. liste des membres
        public function listeDesMembres(): void
        {
            $membres = $this->membre->membersList();
            // la vue
            require_once('view/admin/listeDesMembres.php');
        }
        // voir un membre
        public function voirUnMembre($id_membre): void
        {
            $membre = $this->membre->readOneMember($id_membre);
            // la vue
            require_once('view/admin/voirUnMembre.php');
        }
        // modifier un membre
        public function modifierUnMembre($id_membre, $post): void
        {
            // on récupère le membre
            $membre = $this->membre->readOneMember($id_membre);
            // récup formulaire
            if(isset($_POST['submit'])):
                $this->membre->updateOneMember($id_membre, $post);
                header('Location:/vente-voiture-mvc/admin/gestionDesMembres/listeDesMembres');
                exit();
            endif;
            // la vue
            require_once("view/admin/modifierUnMembre.php");
        }
        // supprimer un membre
        public function supprimerUnMembre($id_membre): void
        {
            $membre = $this->membre->readOneMember($id_membre);
            if(isset($_POST['supprimerUnMembre'])):
                $this->membre->deleteOneMember($id_membre);
                header('Location:/vente-voiture-mvc/admin/gestionDesMembres/listeDesMembres');
                exit();
            endif;
            // la vue
            require_once("view/admin/supprimerUnMembre.php");
        }
    }