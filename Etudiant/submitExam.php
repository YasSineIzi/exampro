<?php
session_start();
include '../db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $exam_id = $_POST['exam_id'];

    foreach ($_POST as $key => $value) {
        if (strpos($key, 'question_') === 0) {
            $question_id = str_replace('question_', '', $key);
            $answer_text = $value;

            // Save the answer to the database
            $stmt = $conn->prepare("INSERT INTO student_answers (student_id, question_id, answer_text) VALUES (?, ?, ?)");
            $stmt->bind_param("iis", $user_id, $question_id, $answer_text);
            $stmt->execute();
        }
    }

    // Calculate the score and save the result
    // This part depends on your scoring logic
    $score = 0; // Calculate the score based on correct answers
    $stmt = $conn->prepare("INSERT INTO results (student_id, exam_id, score, status) VALUES (?, ?, ?, 'pending')");
    $stmt->bind_param("iid", $user_id, $exam_id, $score);
    $stmt->execute();

    header('Location: results.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passer Examen - ExamPro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style/styles.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Include navigation bar -->
            <?php include 'navbar.php'; ?>
            <main class="col-md-9 col-lg-10">
                <div class="container py-5">
                    <h2 class="mb-4">Passer Examen</h2>

                    <?php if ($exam): ?>
                        <!-- Exam Details -->
                        <div class="card mb-4 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title text-primary"><?= htmlspecialchars($exam['title']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($exam['description']) ?></p>
                                <p class="text-muted"><strong>Durée:</strong> <?= htmlspecialchars($exam['duration']) ?> minutes</p>
                            </div>
                        </div>

                        <!-- Questions and Answers Form -->
                        <form action="submitExam.php" method="post" id="examForm">
                            <input type="hidden" name="exam_id" value="<?= $examId ?>">
                            <?php if (!empty($questions)): ?>
                                <ol class="list-group list-group-numbered">
                                    <?php foreach ($questions as $index => $question): ?>
                                        <li class="list-group-item">
                                            <h5><?= ($index + 1) . '. ' . htmlspecialchars($question['question_title']) ?></h5>
                                            <p><?= htmlspecialchars($question['question_text']) ?></p>

                                            <!-- Input Fields for Answers -->
                                            <?php if ($question['type'] == 'text'): ?>
                                                <!-- Short Answer -->
                                                <input type="text" name="answers[<?= $question['id'] ?>]" class="form-control mb-2" placeholder="Votre réponse ici..." required>

                                            <?php elseif ($question['type'] == 'textarea'): ?>
                                                <!-- Long Answer -->
                                                <textarea name="answers[<?= $question['id'] ?>]" class="form-control mb-2" placeholder="Votre réponse ici..." required></textarea>

                                            <?php elseif ($question['type'] == 'radio'): ?>
                                                <!-- Single Choice -->
                                                <?php $options = explode(',', $question['options']); ?>
                                                <?php foreach ($options as $option): ?>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="answers[<?= $question['id'] ?>]" value="<?= htmlspecialchars($option) ?>" required>
                                                        <label class="form-check-label"><?= htmlspecialchars($option) ?></label>
                                                    </div>
                                                <?php endforeach; ?>

                                            <?php elseif ($question['type'] == 'checkbox'): ?>
                                                <!-- Multiple Choice -->
                                                <?php $options = explode(',', $question['options']); ?>
                                                <?php foreach ($options as $option): ?>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="answers[<?= $question['id'] ?>][]" value="<?= htmlspecialchars($option) ?>">
                                                        <label class="form-check-label"><?= htmlspecialchars($option) ?></label>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ol>

                                <!-- Submit Button -->
                                <div class="d-grid gap-2 mt-4">
                                    <button type="submit" class="btn btn-success">Soumettre vos réponses</button>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-warning">Aucune question disponible pour cet examen.</div>
                            <?php endif; ?>
                        </form>
                    <?php else: ?>
                        <div class="alert alert-danger">Examen non trouvé ou non publié.</div>
                    <?php endif; ?>
                </div>
            </main>
        </div>
    </div>

    <!-- JavaScript and Validation -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Client-side validation for required fields
        document.getElementById('examForm').addEventListener('submit', function(event) {
            const inputs = this.querySelectorAll('input[required], textarea[required]');
            let isValid = true;

            inputs.forEach(input => {
                if (!input.value.trim()) {
                    isValid = false;
                    input.classList.add('is-invalid');
                } else {
                    input.classList.remove('is-invalid');
                }
            });

            if (!isValid) {
                event.preventDefault();
                alert('Veuillez répondre à toutes les questions obligatoires.');
            }
        });
    </script>
</body>
</html>
