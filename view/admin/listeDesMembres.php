<?php
    include('./assets/inc/admin/head.inc.php');
?>
    <title>Gestion des membres</title>
<?php
    include('./assets/inc/admin/header.inc.php');
    //echo '<pre>';
    //    var_dump($_GET);
    // echo'</pre>';
    
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
                    <h3>Gestion des membres</h3>
                </div>
                <hr class="w-50 pt-1">
                <table class="table table-light">
                    <thead class="thead-light">
                        <tr class="text-center">
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Statut</th>
                            <th>Détail</th>
                            <th>Modifier</th>
                            <th>Supprimer</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach($membres as $membre):
                        ?>
                        <tr class="text-center">
                            <td><?php echo $membre->nom ?></td>
                            <td><?php echo $membre->email ?></td>
                            <td>
                                <?php
                                    if($membre->statut == 1):
                                        echo 'Administrateur';
                                    else:
                                        echo 'Utilisateur';
                                    endif;
                                ?>
                            </td>
                            <td><a class="btn bg-dark text-light" href="/vente-voiture-mvc/admin/gestionDesMembres/voirUnMembre/<?php echo $membre->id_membre; ?>" type="button" >Détail</a></td>
                            <td><a class="btn bg-dark text-light" href="/vente-voiture-mvc/admin/gestionDesMembres/modifierUnMembre/<?php echo $membre->id_membre; ?>" type="button" >Modifier</a></td>
                            <td><a class="btn bg-dark text-light" href="/vente-voiture-mvc/admin/gestionDesMembres/supprimerUnMembre/<?php echo $membre->id_membre; ?>" type="button" >Supprimer</a></td>
                        </tr>
                        <?php
                            endforeach;
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
<?php
    include('./assets/inc/admin/footer.inc.php');
?>