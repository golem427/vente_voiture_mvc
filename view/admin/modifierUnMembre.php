<?php
    include('./assets/inc/admin/head.inc.php');
?>
<title>Modifier un membre</title>
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
        <div class="row pt-5">
            <h3>Modifier le membre :&ensp;<?php echo $membre->nom; ?></h3>
            <br>
            <div class="row justify-content-center">
                <div class="col-12 col-lg-4">
                    <div class="card rounded-lg mt-5">
                        <div class="card-header">
                            <h3 class="text-center text-dark fw-bold my-4">Modification</h3>
                        </div>
                        <div class="card-body">
                            <form action="" method="post">
                                <input class="form-control my-3" type="text" name="nom" placeholder="<?= $membre->nom ?>">
                                <input class="form-control my-3" type="email" name="email" placeholder="<?= $membre->email ?>">
                                <select name="statut">
                                    <option value="2">Utilisateur</option>
                                    <option value="1">Administrateur</option>
                                </select>
                                <div class="row mt-5">
                                    <div class="col-12 col-lg-6 offset-lg-3 d-flex justify-content-center">
                                        <button class="btn bg-primary fw-bold text-white" type="submit" name="submit">Valider</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 mx-0 px-0">
            <a href="/vente-voiture-mvc/admin/gestionDesMembres/listeDesMembres" type="button" class="btn bg-success text-dark fw-bold">retour à la liste des membres</a>
        </div>
    </div>
</main>
<?php
    include('./assets/inc/admin/footer.inc.php');
?>