<?php
    include('./assets/inc/admin/head.inc.php');
?>
    <title>Détail d'un membre</title>
    <?php
    include('./assets/inc/admin/header.inc.php');
?>
    <main>
        <div class="container">
            <div class="row pt-5">
                <h3>Voir le détail du membre : <?php echo $membre->nom ?></h3>
                <br>
                <p>Email :&ensp;<?php echo $membre->email; ?></p>
                <br>
                <p>Statut :&ensp;
                    <?php
                        if($membre->statut == 1):
                            echo "Cette personne est administrateur";
                            elseif($membre->statut ==2):
                                echo "Cette personne est utilisateur";
                        else:
                            echo "ATTENTION !! Cette personne n'a aucun statut.";
                        endif;
                    ?>
                </p>
            </div>
        </div>
    </main>
<?php
    include('./assets/inc/admin/footer.inc.php');
?>