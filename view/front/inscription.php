<?php
    include('./assets/inc/front/head.inc.php');
?>
<title>inscription</title>
<?php
    include('./assets/inc/front/header.inc.php');
?>
<main>
    <div class="container">
        <?php
            // si il y a un message au niveau de la variable $_SESSION, celui-ci s'affiche
            if(isset($_SESSION['message'])):
                echo '<div class="alert alert-danger mt-5" role="alert">' . $_SESSION['message'] . '</div>';
                unset($_SESSION['message']);
            endif;
        ?>
        <div class="col-12 col-lg-5 pt-5">
            <a href="/vente-voiture-mvc/" type="button" class="btn bg-primary text-white fw-bold">revenir page d'accueil</a>
        </div>
        <div class="row justify-content-center">
            <div class="col-12 col-lg-4">
                <div class="card rounded-lg mt-5">
                    <div class="card-header">
                        <h3 class="text-center text-dark fw-bold my-4">Créer votre compte</h3>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <input class="form-control my-3" type="text" name="nom" placeholder="Entrer votre nom">
                            <input class="form-control my-3" type="email" name="email" placeholder="Entrer votre email">
                            <input class="form-control my-3" type="password" name="password" placeholder="Entrer votre mot de passe">
                            <div class="col-12 col-lg-6 offset-lg-3 d-flex justify-content-center">
                                <button class="btn bg-primary text-white fw-bold" type="submit" name="submit">Valider</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php
    include('./assets/inc/front/footer.inc.php');
?>