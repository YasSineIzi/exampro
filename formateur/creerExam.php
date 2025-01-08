<?php
session_start();
require "../db.php"; // Ensure the correct path to the config file

// Fonction pour sauvegarder l'examen
function saveExam($pdo, $examData, $questions) {
    try {
        $pdo->beginTransaction();
        
        // Insertion de l'examen
        $stmt = $pdo->prepare("INSERT INTO exams (title, description, duration, user_id, status) VALUES (:title, :description, :duration, :user_id, :status)");
        $stmt->execute([
            ':title' => $examData['title'],
            ':description' => $examData['description'],
            ':duration' => $examData['duration'],
            ':user_id' => $_SESSION['user_id'],
            ':status' => 'published'
        ]);
        
        $examId = $pdo->lastInsertId();
        
        // Insertion des questions
        foreach ($questions as $question) {
            $stmt = $pdo->prepare("INSERT INTO questions (exam_id, title, type, details, points) VALUES (:exam_id, :title, :type, :details, :points)");
            $stmt->execute([
                ':exam_id' => $examId,
                ':title' => $question['title'],
                ':type' => $question['type'],
                ':details' => json_encode($question['details']),
                ':points' => $question['points']
            ]);
        }
        
        $pdo->commit();
        return true;
    } catch (Exception $e) {
        $pdo->rollBack();
        throw $e;
    }
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $examData = [
            'title' => $_POST['examTitle'],
            'description' => $_POST['examDescription'],
            'duration' => $_POST['examDuration']
        ];
        
        $questions = json_decode($_POST['questions'], true);
        
        if (saveExam($pdo, $examData, $questions)) {
            echo json_encode(['status' => 'success', 'message' => 'Examen créé avec succès']);
        }
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un examen - ExamPro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php include 'includes/sidebar.php'; ?>

            <main class="col-md-9 col-lg-10 px-md-4">
                <div class="container py-5">
                    <h2 class="mb-4">Créer un nouvel examen</h2>
                    
                    <form id="examForm" method="POST">
                        <!-- Informations générales de l'examen -->
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Informations générales</h5>
                                <div class="mb-3">
                                    <label for="examTitle" class="form-label">Titre de l'examen</label>
                                    <input type="text" class="form-control" id="examTitle" name="examTitle" required>
                                </div>
                                <div class="mb-3">
                                    <label for="examDescription" class="form-label">Description</label>
                                    <textarea class="form-control" id="examDescription" name="examDescription" rows="3"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="examDuration" class="form-label">Durée (minutes)</label>
                                    <input type="number" class="form-control" id="examDuration" name="examDuration" value="60" min="15" required>
                                </div>
                            </div>
                        </div>

                        <!-- Container pour les questions -->
                        <div id="questionsContainer"></div>

                        <button type="button" class="btn btn-outline-primary mb-3" id="addQuestion">
                            Ajouter une question
                        </button>

                        <button type="submit" class="btn btn-primary">Enregistrer l'examen</button>
                    </form>
                </div>
            </main>
        </div>
    </div>

    <script>
        let questionCounter = 0;

        // Fonction pour ajouter une nouvelle question
        function addQuestion() {
            questionCounter++;
            const questionTemplate = `
                <div class="card mb-3 question-card" data-question-id="${questionCounter}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5 class="card-title">Question ${questionCounter}</h5>
                            <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeQuestion(${questionCounter})">
                                Supprimer
                            </button>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Type de question</label>
                            <select class="form-select question-type" onchange="updateQuestionFields(${questionCounter})">
                                <option value="qcm">QCM</option>
                                <option value="short">Réponse courte</option>
                                <option value="open">Question ouverte</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Énoncé de la question</label>
                            <input type="text" class="form-control question-title" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Points</label>
                            <input type="number" class="form-control question-points" value="1" min="1" required>
                        </div>

                        <div class="question-details"></div>
                    </div>
                </div>
            `;

            document.getElementById('questionsContainer').insertAdjacentHTML('beforeend', questionTemplate);
            updateQuestionFields(questionCounter);
        }

        // Mise à jour des champs spécifiques au type de question
        function updateQuestionFields(questionId) {
            const questionCard = document.querySelector(`[data-question-id="${questionId}"]`);
            const type = questionCard.querySelector('.question-type').value;
            const detailsContainer = questionCard.querySelector('.question-details');

            let template = '';
            if (type === 'qcm') {
                template = `
                    <div class="mb-3">
                        <label class="form-label">Options</label>
                        <div class="options-container">
                            <div class="input-group mb-2">
                                <input type="text" class="form-control option-text" placeholder="Option 1" required>
                                <div class="input-group-text">
                                    <input type="checkbox" class="option-correct" title="Cocher si c'est la bonne réponse">
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="addOption(${questionId})">
                            Ajouter une option
                        </button>
                    </div>
                `;
            } else if (type === 'short') {
                template = `
                    <div class="mb-3">
                        <label class="form-label">Réponse attendue</label>
                        <input type="text" class="form-control expected-answer" required>
                    </div>
                `;
            } else if (type === 'open') {
                template = `
                    <div class="mb-3">
                        <label class="form-label">Guide de correction</label>
                        <textarea class="form-control correction-guide" rows="3"></textarea>
                    </div>
                `;
            }

            detailsContainer.innerHTML = template;
        }

        // Fonction pour ajouter une option à un QCM
        function addOption(questionId) {
            const questionCard = document.querySelector(`[data-question-id="${questionId}"]`);
            const optionsContainer = questionCard.querySelector('.options-container');
            const optionCount = optionsContainer.children.length + 1;

            const optionTemplate = `
                <div class="input-group mb-2">
                    <input type="text" class="form-control option-text" placeholder="Option ${optionCount}" required>
                    <div class="input-group-text">
                        <input type="checkbox" class="option-correct" title="Cocher si c'est la bonne réponse">
                    </div>
                </div>
            `;

            optionsContainer.insertAdjacentHTML('beforeend', optionTemplate);
        }

        // Fonction pour supprimer une question
        function removeQuestion(questionId) {
            document.querySelector(`[data-question-id="${questionId}"]`).remove();
        }

        // Ajouter une première question au chargement
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('addQuestion').addEventListener('click', addQuestion);
            addQuestion();
        });

        // Gestionnaire du formulaire
        document.getElementById('examForm').addEventListener('submit', async (e) => {
            e.preventDefault();

            const examData = {
                title: document.getElementById('examTitle').value,
                description: document.getElementById('examDescription').value,
                duration: document.getElementById('examDuration').value,
                questions: []
            };

            // Collecter les données de chaque question
            document.querySelectorAll('.question-card').forEach(questionCard => {
                const questionData = {
                    title: questionCard.querySelector('.question-title').value,
                    type: questionCard.querySelector('.question-type').value,
                    points: questionCard.querySelector('.question-points').value,
                    details: {}
                };

                if (questionData.type === 'qcm') {
                    questionData.details.options = [];
                    questionCard.querySelectorAll('.input-group').forEach(optionGroup => {
                        questionData.details.options.push({
                            text: optionGroup.querySelector('.option-text').value,
                            correct: optionGroup.querySelector('.option-correct').checked
                        });
                    });
                } else if (questionData.type === 'short') {
                    questionData.details.answer = questionCard.querySelector('.expected-answer').value;
                } else if (questionData.type === 'open') {
                    questionData.details.guide = questionCard.querySelector('.correction-guide').value;
                }

                examData.questions.push(questionData);
            });

            try {
                const response = await fetch('creerExam.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        examTitle: examData.title,
                        examDescription: examData.description,
                        examDuration: examData.duration,
                        questions: JSON.stringify(examData.questions)
                    })
                });

                const responseText = await response.text();
                console.log(responseText); // Log the response text for debugging

                const result = JSON.parse(responseText);
                if (result.status === 'success') {
                    alert('Examen créé avec succès !');
                    window.location.href = 'lesExamCreé.php';
                } else {
                    alert('Erreur lors de la création de l\'examen : ' + result.message);
                }
            } catch (error) {
                alert('Erreur lors de la création de l\'examen : ' + error.message);
            }
        });
    </script>
</body>
</html>