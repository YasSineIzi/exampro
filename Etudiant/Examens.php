<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Examens - ExamPro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
   <link rel="stylesheet" href="style/styles.css">
   <script src="script.js"></script>
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <?php include 'navbar.php'; ?>


        <!-- Main Content -->
        <main class="content">
            <div class="main-content">
                <header class="d-flex justify-content-between align-items-center border-bottom py-3">
                    <h1>Examens</h1>
                    <a href="profil.php" class="nav-link">
                        <i class="fas fa-user profile-icon"></i>
                    </a>
                </header>

                <!-- Exam content goes here -->
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="card-title">Liste des examens</h2>
                        <p class="card-text">Ici, vous trouverez la liste de vos examens à venir et passés.</p>
                        <!-- Add exam list or other relevant content here -->
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>