<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - ExamPro</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 bg-light sidebar py-4">
                <div class="text-center mb-4">
                    <h2 class="text-primary">ExamPro</h2>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item mb-3">
                        <a href="#" class="nav-link active text-primary">Accueil</a>
                    </li>
                    <li class="nav-item mb-3">
                        <a href="creerExam.php" class="nav-link">Créer exame</a>
                    </li>
                    <li class="nav-item mb-3">
                        <a href="exams.html" class="nav-link">Examens</a>
                    </li>
                    <li class="nav-item">
                        <a href="login.php" class="nav-link text-danger">Déconnexion</a>
                    </li>
                </ul>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 col-lg-10">
                <!-- Header -->
                <header class="d-flex justify-content-between align-items-center border-bottom py-3 px-4">
                    <h3>Accueil</h3>
                    <div class="d-flex align-items-center">
                        <span class="me-3">🔔</span>
                        <!-- <span>Admin</span> -->
                         <a href="PageProfilUtilisateur.php">Formateur</a>
                    </div>
                </header>

                <!-- Dashboard Content -->
                <div class="container py-5">
                    <h2 class="mb-4 text-primary">Bienvenue sur ExamPro</h2>
                    <p class="text-muted">Gérez vos examens et vos questions de manière simple et efficace.</p>

                    <!-- Section statistiques -->
                    <div class="row mb-5">
                        <div class="col-md-4">
                            <div class="card text-center shadow-sm border-primary">
                                <div class="card-body">
                                    <h3 class="text-primary">12</h3>
                                    <p class="card-text">Examens Créés</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-center shadow-sm border-success">
                                <div class="card-body">
                                    <h3 class="text-success">85</h3>
                                    <p class="card-text">Questions Ajoutées</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-center shadow-sm border-warning">
                                <div class="card-body">
                                    <h3 class="text-warning">5</h3>
                                    <p class="card-text">Examens en attente</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section actions rapides -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card text-center shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title">Créer exame</h5>
                                    <p class="card-text">Ajoutez et gérez vos questions pour les examens.</p>
                                    <a href="creerExam.php" class="btn btn-primary">Créer</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-center shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title">Examens</h5>
                                    <p class="card-text">Visualisez et modifiez vos examens existants.</p>
                                    <a href="exams.html" class="btn btn-primary">Voir</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-center shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title">Rapports et Statistiques</h5>
                                    <p class="card-text">Analysez les performances des étudiants.</p>
                                    <a href="stats.html" class="btn btn-secondary">Voir</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <footer class="bg-light text-center py-3 mt-5">
        <p class="mb-0">&copy; 2024 ExamPro. Tous droits réservés.</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>