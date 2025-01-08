<?php
session_start();
include '../db.php';  // Include your database connection file

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Assuming user is logged in and user ID is stored in session
$user_id = $_SESSION['user_id']; 

// Fetch user data
$query = "SELECT name, email FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($name, $email);
$stmt->fetch();
$stmt->close();

// Update personal info
if (isset($_POST['update_info'])) {
    $new_name = $_POST['name'];
    $new_email = $_POST['email'];

    // Validate and update the personal information
    if (!empty($new_name) && !empty($new_email)) {
        $update_query = "UPDATE users SET name = ?, email = ? WHERE id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("ssi", $new_name, $new_email, $user_id);
        if ($stmt->execute()) {
            $success = "Informations personnelles mises à jour avec succès.";
        } else {
            $error = "Erreur lors de la mise à jour des informations personnelles.";
        }
        $stmt->close();
    }
}

// Change password
if (isset($_POST['change_password'])) {
    $current_password = $_POST['currentPassword'];
    $new_password = $_POST['newPassword'];
    $confirm_password = $_POST['confirmPassword'];

    // Fetch current password from the database
    $query = "SELECT password FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    $stmt->close();

    // Verify the current password
    if (password_verify($current_password, $hashed_password)) {
        // Check if new passwords match
        if ($new_password === $confirm_password) {
            // Hash the new password
            $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Update the password in the database
            $update_password_query = "UPDATE users SET password = ? WHERE id = ?";
            $stmt = $conn->prepare($update_password_query);
            $stmt->bind_param("si", $hashed_new_password, $user_id);
            if ($stmt->execute()) {
                $success = "Mot de passe modifié avec succès.";
            } else {
                $error = "Erreur lors de la modification du mot de passe.";
            }
            $stmt->close();
        } else {
            $error = "Les mots de passe ne correspondent pas.";
        }
    } else {
        $error = "Le mot de passe actuel est incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Utilisateur - ExamPro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="style/styles.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php require "navbar.php"?>


            <!-- Main Content -->
            <main class="col-md-9 col-lg-10">
                <div class="p-4">
                    <h1 class="mb-4">Profil Utilisateur</h1>

                    <!-- Messages -->
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
                    <?php endif; ?>
                    <?php if (!empty($success)): ?>
                        <div class="alert alert-success"><?= htmlspecialchars($success); ?></div>
                    <?php endif; ?>

                    <!-- Profil Section -->
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="row">
                                <!-- Photo de profil -->
                                <div class="col-md-4 text-center">
                                    <img src="https://via.placeholder.com/150" alt="Photo de profil" class="rounded-circle mb-3" width="150" height="150">
                                    <button class="btn btn-outline-primary btn-sm">Changer la photo</button>
                                </div>

                                <!-- Informations personnelles -->
                                <div class="col-md-8">
                                    <h4 class="mb-3">Informations personnelles</h4>
                                    <form method="POST">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Nom</label>
                                            <input type="text" disabled class="form-control" id="name" name="name" value="<?= htmlspecialchars($name); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Adresse email</label>
                                            <input type="email" disabled class="form-control" id="email" name="email" value="<?= htmlspecialchars($email); ?>" required>
                                        </div>
                                        <!-- <button type="submit" name="update_info" class="btn btn-primary">Mettre à jour</button> -->
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modifier le mot de passe -->
                    <section class="mb-5">
                        <h4 class="mb-3">Modifier le mot de passe</h4>
                        <form method="POST">
                            <div class="mb-3">
                                <label for="currentPassword" class="form-label">Mot de passe actuel</label>
                                <input type="password" class="form-control" id="currentPassword" name="currentPassword" required>
                            </div>
                            <div class="mb-3">
                                <label for="newPassword" class="form-label">Nouveau mot de passe</label>
                                <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                            </div>
                            <div class="mb-3">
                                <label for="confirmPassword" class="form-label">Confirmer le nouveau mot de passe</label>
                                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                            </div>
                            <button type="submit" name="change_password" class="btn btn-primary">Changer le mot de passe</button>
                        </form>
                    </section>

                </div>
            </main>
        </div>
    </div>
    <script src="script.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
