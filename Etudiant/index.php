<?php
// Inclure la connexion à la base de données
include '../db.php';

// Récupérer les cours depuis la base de données
$sql = "SELECT * FROM cours";
$result = $conn->query($sql);

// Vérifier si des cours sont trouvés
$courses = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $courses[] = $row;
    }
} else {
    $message = "Aucun cours trouvé.";
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Cours - ExamPro</title>
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
                    <h1>Mes cours</h1>
                    <a href="profil.php" class="nav-link">
                        <i class="fas fa-user profile-icon"></i>
                    </a>
                </header>

                <!-- Courses Section -->
                <section class="courses-section">
                    <div class="row g-4">
                        <?php foreach ($courses as $course): ?>
                            <div class="col-md-6 col-lg-4">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <h5 class="card-title text-primary"><?= htmlspecialchars($course['name']); ?></h5>
                                        <p class="card-text"><?= htmlspecialchars($course['description']); ?></p>
                                        <?php if (!empty($course['file_path'])): ?>
                                            <a href="<?= htmlspecialchars($course['file_path']); ?>" class="btn btn-primary"
                                                download>Télécharger le fichier</a>
                                        <?php else: ?>
                                            <p class="text-muted">Aucun fichier disponible</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
   
</body>

</html>