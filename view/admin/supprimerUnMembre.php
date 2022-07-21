<?php
    include('./assets/inc/admin/head.inc.php');
?>
<title>Supprimer un membre</title>
<?php
    include('./assets/inc/admin/header.inc.php');
?>
<main>
    <div class="container">
        <?php
            if (isset($_SESSION['message'])) :
                echo '<div class="alert alert-success mt-5" role="alert">' . $_SESSION['message'] . '</div>';
                unset($_SESSION['message']);
            endif;
        ?>

        <div class="row pt-5 px-0">
            <h3>Supprimer le membre&ensp;<?php echo $membre->nom; ?></h3>
            <br>
            <p>ATTENTION VOUS ÊTES SUR LE POINT DE SUPPRIMER CE MEMBRE !!!</p>
            <br>
            <p>Veuillez confirmer la suppression en selectionnant le bouton rouge.<br>
                vous pouvez revenir à la liste des membres en selectionnant le bouton vert.
            </p>
            <div class="col-12 col-lg-6 mx-0 px-0">
                <form action="" method="post">
                    <button class="btn bg-danger text-white fw-bold" type="submit" name="supprimerUnMembre">Supprimer le Membre</button>
                </form>
            </div>
            <div class="col-12 col-lg-6 mx-0 px-0">
                <a href="/vente-voiture-mvc/admin/gestionDesMembres/listeDesMembres" type="button" class="btn bg-success text-dark fw-bold">retour à la liste des membres</a>
            </div>
        </div>
</main>
<?php
    include('./assets/inc/admin/footer.inc.php');
?>