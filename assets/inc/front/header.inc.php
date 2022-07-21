</head>
    <body>
        <header>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">Vente-Voiture</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="#">Accueil</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">panier</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Contact</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-12 col-lg-4">
                    <?php
                        // si $_SESSION['isLog'] n'existe pas ou si l'utilisateur n'est pas
                        // connecté
                        if(isset($_SESSION['isLog']) ==false || ($_SESSION['isLog']) == false):
                    ?>
                        <a href="inscription" type="button" class="btn bg-dark text-white fw-bold">Inscription</a>
                        <a href="seConnecter" type="button" class="btn bg-dark text-white fw-bold">Connexion</a>
                    <?php
                            elseif($_SESSION['isLog'] == true && $_SESSION['admin'] == true):
                    ?>
                                <span class="text-dark fw-bold">Bienvenue <?php echo $_SESSION['nom'] ?></span>
                                <a href="seDeconnecter" type="button" class="btn bg-dark text-white fw-bold">Deconnexion</a>
                                <a href="admin/bienvenueAdmin/pageAccueilAdmin" type="button" class="btn bg-dark text-white fw-bold">BackOffice</a>
                    <?php
                        else:
                    ?>
                            <span class="text-dark fw-bold">Bienvenue <?php echo $_SESSION['nom'] ?></span>
                            <a href="seDeconnecter" type="button" class="btn bg-dark text-white fw-bold">Deconnexion</a>
                    <?php
                        endif;
                    ?>
                    </div>
                </div>
            </nav>
        </header>