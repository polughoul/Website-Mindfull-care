<?php
/**
 * Start a new session or resume the existing session.
 */
session_start();

/**
 * Delete feedback for a user.
 *
 * Takes a username from the input data, loads user data, and removes the feedback for the specified user.
 * Outputs a JSON response indicating the success of the operation.
 */
function deleteFeedback(): void
{
    // Get input data from the PHP input stream
    $data = json_decode(file_get_contents('php://input'), true);

    // Check if the user is logged in and has the necessary privileges
    if (isset($_SESSION['user']['uname']) && (isset($data['username']) || $_SESSION['user']['isAdmin'])) {
        // Extract the username from the input data
        $username = $data['username'];

        // Load data of all users
        $usersData = json_decode(file_get_contents("users.json"), true);

        // Find the user and remove their feedback
        foreach ($usersData as &$userData) {
            if ($userData['uname'] === $username) {
                unset($userData['feedback']);
                unset($userData['date_feedbacks']);
                break;
            }
        }

        // Save the updated data
        file_put_contents("users.json", json_encode($usersData));

        // Send a JSON response indicating success
        echo json_encode(['success' => true]);
    } else {
        // Send a JSON response indicating failure due to an invalid request
        echo json_encode(['success' => false, 'error' => 'Invalid request']);
    }
    exit();
}

deleteFeedback();
