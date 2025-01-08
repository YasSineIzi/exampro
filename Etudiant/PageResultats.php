<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats - ExamPro</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="script.js"></script>   
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style/styles.css">
</head>
<body>
    <div class="wrapper">
    
            <!-- Sidebar -->
            <?php include 'navbar.php'; ?>
            <!-- Main Content -->
            <main class="content">
            
            <div class="main-content">
                <header class="d-flex justify-content-between align-items-center border-bottom py-3">
                    <h1>Mes Résultats</h1>
                    <a href="profil.php" class="nav-link">
                        <i class="fas fa-user profile-icon"></i>
                    </a>
                </header>

                <!-- Résultats Section -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <thead class="table-primary">
                                <tr>
                                    <th>#</th>
                                    <th>Examen</th>
                                    <th>Cours</th>
                                    <th>Date</th>
                                    <th>Score</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Examen Final</td>
                                    <td>Mathématiques</td>
                                    <td>15/12/2024</td>
                                    <td>18/20</td>
                                    <td><span class="badge bg-success">Réussi</span></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Interrogation</td>
                                    <td>Physique</td>
                                    <td>12/12/2024</td>
                                    <td>12/20</td>
                                    <td><span class="badge bg-warning">Passable</span></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Test</td>
                                    <td>Anglais</td>
                                    <td>10/12/2024</td>
                                    <td>8/20</td>
                                    <td><span class="badge bg-danger">Échoué</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Analyse des Performances -->
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4>Analyse des performances</h4>
                        <ul class="list-unstyled">
                            <li><strong>Moyenne générale :</strong> 12.7/20</li>
                            <li><strong>Nombre d'examens réussis :</strong> 1</li>
                            <li><strong>Nombre d'échecs :</strong> 1</li>
                            <li><strong>Performance globale :</strong> <span class="text-success">Satisfaisant</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </main>
        </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
