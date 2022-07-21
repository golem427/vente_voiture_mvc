</head>
    <body>
        <header>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">Back-office</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="/vente-voiture-mvc/">retour accueil admin.</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/vente-voiture-mvc/admin/gestionDesMembres/listeDesMembres">Gestion Membres</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Gestion Voitures</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-12 col-lg-3">
                        <span class="text-class fw-bold">Bienvenue <?php echo $_SESSION['nom']; ?></span>
                    </div>
                </div>
            </nav>
        </header>