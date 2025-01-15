<?php
session_start();
require_once '../db.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Vérifier si l'exam_id est fourni dans l'URL
if (!isset($_GET['exam_id'])) {
    header('Location: exams.php');
    exit;
}

$exam_id = $_GET['exam_id'];

try {
    // Récupérer les détails de l'examen
    $stmt = $conn->prepare("SELECT * FROM exams WHERE id = ? AND published = 1");
    $stmt->bind_param("i", $exam_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $exam = $result->fetch_assoc();

    // Si l'examen n'existe pas ou n'est pas publié, rediriger
    if (!$exam) {
        header('Location: exams.php');
        exit;
    }

    // Récupérer les questions de l'examen
    $stmt = $conn->prepare("SELECT * FROM questions WHERE exam_id = ?");
    $stmt->bind_param("i", $exam_id);
    $stmt->execute();
    $questions = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passer l'examen - ExamPro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        .question {
            margin-bottom: 2rem;
            padding: 1rem;
            border: 1px solid #ddd;
            border-radius: 0.5rem;
            background-color: #f9f9f9;
        }
        .question h4 {
            margin-bottom: 1rem;
        }
        .question label {
            display: block;
            margin-bottom: 0.5rem;
        }
        .question textarea {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 0.25rem;
        }
        .question input[type="text"] {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 0.25rem;
        }
        .btn-submit {
            margin-top: 2rem;
        }
        .points {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4"><?= htmlspecialchars($exam['title']) ?></h1>
        <p class="lead"><?= htmlspecialchars($exam['description']) ?></p>
        <hr>

        <form action="submitExam.php" method="post">
            <input type="hidden" name="exam_id" value="<?= $exam_id ?>">

            <?php if (is_array($questions) && !empty($questions)): ?>
                <?php foreach ($questions as $question): ?>
                    <div class="question">
                        <h4><?= htmlspecialchars($question['question_title']) ?></h4>
                        <div class="points">Points : <?= htmlspecialchars($question['points']) ?></div>

                        <?php if ($question['type'] === 'mcq'): ?>
                            <!-- Question à choix multiple (MCQ) -->
                            <?php
                            // Décoder les options du QCM
                            $details = json_decode($question['details'], true);
                            $options = $details['options']; // Récupérer les options
                            ?>
                            <?php foreach ($options as $option): ?>
                                <label>
                                    <input type="radio" name="question_<?= $question['id'] ?>" value="<?= htmlspecialchars($option['text']) ?>" required>
                                    <?= htmlspecialchars($option['text']) ?>
                                </label><br>
                            <?php endforeach; ?>

                        <?php elseif ($question['type'] === 'open'): ?>
                            <!-- Question ouverte -->
                            <textarea name="question_<?= $question['id'] ?>" rows="4" placeholder="Votre réponse..." required></textarea>

                        <?php elseif ($question['type'] === 'short'): ?>
                            <!-- Question courte -->
                            <input type="text" name="question_<?= $question['id'] ?>" placeholder="Votre réponse..." required>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="alert alert-warning">Aucune question disponible pour cet examen.</div>
            <?php endif; ?>

            <button type="submit" class="btn btn-primary btn-submit">Soumettre l'examen</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>