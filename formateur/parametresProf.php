<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paramètres du Compte - ExamPro</title>
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
                        <a href="index.html" class="nav-link">Accueil</a>
                    </li>
                    <li class="nav-item mb-3">
                        <a href="create-question.html" class="nav-link">Créer Questions</a>
                    </li>
                    <li class="nav-item mb-3">
                        <a href="Accueil.php" class="nav-link">Examens</a>
                    </li>
                    <li class="nav-item mb-3">
                        <a href="#" class="nav-link active text-primary">Paramètres du Compte</a>
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
                    <h3>Paramètres du Compte</h3>
                    <div class="d-flex align-items-center">
                        <span class="me-3">🔔</span>
                        <span>Admin</span>
                    </div>
                </header>

                <!-- Account Settings Content -->
                <div class="container py-5">
                    <h4 class="mb-4 text-primary">Modifier les paramètres de votre compte</h4>
                    
                    <!-- Formulaire de paramètres de compte -->
                    <form>
                        <!-- Informations personnelles -->
                        <div class="mb-5">
                            <h5 class="fw-bold">Informations personnelles</h5>
                            <div class="mb-3">
                                <label for="username" class="form-label">Nom d'utilisateur</label>
                                <input type="text" id="username" class="form-control" value="Admin" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Adresse email</label>
                                <input type="email" id="email" class="form-control" value="admin@example.com" required>
                            </div>
                        </div>

                        <!-- Modifier le mot de passe -->
                        <div class="mb-5">
                            <h5 class="fw-bold">Modifier le mot de passe</h5>
                            <div class="mb-3">
                                <label for="currentPassword" class="form-label">Mot de passe actuel</label>
                                <input type="password" id="currentPassword" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="newPassword" class="form-label">Nouveau mot de passe</label>
                                <input type="password" id="newPassword" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="confirmPassword" class="form-label">Confirmer le nouveau mot de passe</label>
                                <input type="password" id="confirmPassword" class="form-control" required>
                            </div>
                        </div>

                        <!-- Notifications -->
                        <div class="mb-5">
                            <h5 class="fw-bold">Préférences de notification</h5>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="emailNotifications" checked>
                                <label class="form-check-label" for="emailNotifications">Recevoir les notifications par email</label>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="smsNotifications">
                                <label class="form-check-label" for="smsNotifications">Recevoir les notifications par SMS</label>
                            </div>
                        </div>

                        <!-- Boutons d'action -->
                        <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                        <button type="reset" class="btn btn-outline-secondary">Réinitialiser</button>
                    </form>
                </div>
            </main>
        </div>
    </div>

    <footer class="bg-light text-center py-3 mt-5">
        <p class="mb-0">&copy; 2024 ExamPro. Tous droits réservés.</p>
    </footer>
</body>
</html>
