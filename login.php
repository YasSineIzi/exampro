<?php
// Démarre une session pour stocker les informations de l'utilisateur
session_start();

// Inclure la connexion à la base de données
include 'db.php';

$error = ''; // Variable pour stocker les messages d'erreur

// Vérifier si le formulaire de connexion a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les informations du formulaire et les nettoyer
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Vérifier si les champs sont remplis
    if (!empty($email) && !empty($password)) {
        // Préparer une requête pour récupérer l'utilisateur en fonction de l'email
        $sql = "SELECT id, name, email, password, role FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            // Vérifier si un utilisateur avec cet email existe
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($id, $name, $db_email, $db_password, $role);
                $stmt->fetch();

                // Vérifier si le mot de passe correspond
                if ($password === $db_password) { // Comparaison directe des mots de passe
                    // Les informations de connexion sont correctes, démarrer la session
                    $_SESSION['user_id'] = $id;
                    $_SESSION['user_name'] = $name;
                    $_SESSION['user_email'] = $db_email;
                    $_SESSION['user_role'] = $role;


                    // Rediriger l'utilisateur en fonction de son rôle
                    if ($role == 'admin') {
                        header("Location: Admin");
                    } elseif ($role == 'teacher') {
                        header("Location: formateur");
                    } else {
                        header("Location: Etudiant");
                    }
                    exit(); // Arrêter l'exécution du script après la redirection
                } else {
                    // Mot de passe incorrect
                    $error = "Mot de passe incorrect.";
                }
            } else {
                // Email non trouvé
                $error = "Aucun utilisateur trouvé avec cet email.";
            }

            $stmt->close();
        } else {
            $error = "Erreur lors de la connexion à la base de données.";
        }
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
    header("Location: profil.php");
    exit();

}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - ExamPro</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            min-height: calc(100vh - 4rem);
            background-color: rgba(0, 0, 0, 0.3);
            background-image: url('https://images.unsplash.com/photo-1516979187457-637abb4f9353?q=80&w=1470&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-blend-mode: darken;
            position: relative;
            animation: fadeIn 2s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .card {
            border: none;
            border-radius: 10px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {

            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }

        .btn-primary {
            background: #48c6ef;
            border: none;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .btn-primary:hover {
            background: #6f86d6;
            transform: scale(1.05);
        }

        .text-primary {
            color: #48c6ef !important;
        }

        .form-control:focus {
            border-color: #6f86d6;
            box-shadow: 0 0 8px rgba(72, 198, 239, 0.5);
        }

        a.text-decoration-none:hover {
            color: #6f86d6;
            text-decoration: underline;
        }
        .text{
            color: #3b82f6 /* hover:from-blue-500 hover:to-blue-300 */

           
        }
    </style>
</head>

<body>
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow-sm p-4" style="width: 100%; max-width: 400px;">
            <div class="text-center mb-4">
                <h2 class="text"><i class="fas fa-graduation-cap"></i> ExamPro</h2>
                <p class="text-muted">Veuillez vous connecter pour accéder à votre compte</p>
            </div>
            <form method="POST" action="">
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <div class="mb-3">
                    <label for="email" class="form-label">Adresse Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" class="form-control" id="email" name="email"
                            placeholder="exemple@domaine.com" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password"
                            required>
                    </div>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Connexion</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>