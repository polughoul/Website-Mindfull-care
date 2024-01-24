<?php
/**
 * Start a new session or resume the existing session.
 */
session_start();

/**
 * Process and save user feedback.
 *
 * Validates the length and content of the feedback, adds the feedback to the user data,
 * and saves the updated user data to the users.json file.
 */
function processFeedback(): void
{
    // Check if the necessary data is present in the session and POST request
    if (isset($_SESSION['user']['uname']) && isset($_POST['feedback']) && isset($_POST['date_feedbacks'])) {
        // Extract data from the POST request
        $user = $_SESSION['user']['uname'];
        $feedback = $_POST['feedback'];
        $dateFeedbacks = $_POST['date_feedbacks'];

        // Validate the length and content of the feedback
        validateFeedback($feedback);

        // Load data for all users
        $usersData = json_decode(file_get_contents("users.json"), true);

        // Find the user and add their feedback
        foreach ($usersData as &$userData) {
            if ($userData['uname'] === $user) {
                $userData['feedback'] = $feedback;
                $userData['date_feedbacks'] = $dateFeedbacks;
                break;
            }
        }

        // Save the updated data
        file_put_contents("users.json", json_encode($usersData));

        // Return success message
        echo json_encode(['success' => true, 'message' => 'Feedback saved!']);
        exit();
    }
}

/**
 * Validate the length and content of the feedback.
 *
 * Checks if the feedback has a valid length and contains only alphanumeric characters and spaces.
 *
 * @param string $feedback The feedback to be validated.
 */
function validateFeedback($feedback): void
{
    $feedbackLength = strlen($feedback);

    if ($feedbackLength < 10 || $feedbackLength > 300) {
        // If the feedback is too short or too long, redirect the user back to the feedback page with an error message
        echo json_encode(['success' => false, 'message' => 'Feedback must be between 10 and 300 characters long.']);
        exit();
    }

    if (!preg_match('/^[a-zA-Z0-9\s\p{P}]+$/u', $feedback)) {
        // If the feedback contains invalid characters, redirect the user back to the feedback page with an error message
        echo json_encode(['success' => false, 'message' => 'Only latin letters, please.']);
        exit();
    }
}

/**
 * Load and return paginated feedbacks from the users.json file.
 *
 * @param int $page Current page number.
 * @param int $perPage Number of feedbacks per page.
 * @return array Paginated feedbacks.
 */
function loadPaginatedFeedbacks($page, $perPage): array
{
    $usersData = json_decode(file_get_contents("users.json"), true);

    usort($usersData, function ($a, $b) {
        $dateA = isset($a['date_feedbacks']) ? strtotime($a['date_feedbacks']) : 0;
        $dateB = isset($b['date_feedbacks']) ? strtotime($b['date_feedbacks']) : 0;
        return $dateB - $dateA;
    });
    $start = ($page - 1) * $perPage;
    return array_slice($usersData, $start, $perPage);
}

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$perPage = isset($_GET['perPage']) ? intval($_GET['perPage']) : 4;

$paginatedFeedbacks = loadPaginatedFeedbacks($page, $perPage);
processFeedback();

echo json_encode($paginatedFeedbacks);
