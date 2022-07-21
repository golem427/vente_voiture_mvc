    <?php
        include('./assets/inc/front/head.inc.php');
        // on appelle le code de configuration config.php
        require_once('./config/config.php');
    ?>
        <title>Page d'accueil</title>
    <?php
        include('./assets/inc/front/header.inc.php');
    ?>
        <main>
            <div class="container mt-3">
            <?php
                // si il y a un message au niveau de la variable $_SESSION, celui-ci s'affiche
                if(isset($_SESSION['message'])):
                    echo '<div class="alert alert-success mt-5" role="alert">' . $_SESSION['message'] . '</div>';
                    unset($_SESSION['message']);
                endif;
            ?>
            <?php
                // echo '<pre>';
                //    var_dump($_SESSION);
                // echo'</pre>';
            ?>
                <h3>Liste des voitures à vendre</h3>
                <div class="row pt-3">
                    <?php
                        foreach($voitures as $voiture):
                    ?>
                    <div class="col-12 col-lg-3 mt-3">
                        <div class="card" style="width: 18rem;">
                            <img src="..." class="card-img-top text-dark" alt="nom_image">
                            <div class="card-body text-dark">
                                <h5 class="card-title"><?php echo $voiture->nom ?></h5>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><?php echo $voiture->marque ?></li>
                                <li class="list-group-item"><?php echo $voiture->couleur ?></li>
                                <li class="list-group-item"><?php echo $voiture->prix ?>&ensp;€</li>
                            </ul>
                            <div class="card-body">
                                <a href="#" type="button" class="btn bg-primary text-light">Ajouter au panier</a>
                            </div>
                        </div>
                    </div>
                    <?php
                        endforeach;
                    ?>
                </div>
            </div>
        </main>
    <?php
        include('./assets/inc/front/footer.inc.php');
    ?>