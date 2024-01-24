<?php
/**
 * Set the content type to JSON.
 */
header('Content-Type: application/json');

/**
 * Retrieve the secret question for a given username.
 *
 * This function reads the users.json file, searches for the user with the
 * provided username, and returns the secret question associated with that user.
 * If the user is not found, it returns an error message.
 */
function getSecretQuestion(): void
{
    // Get the username from the request
    $data = json_decode(file_get_contents('php://input'), true);
    $username = trim($data['uname']);

    // Load user data from the users.json file
    $usersData = json_decode(file_get_contents('users.json'), true);

    // Find the user with the given username
    foreach ($usersData as $user) {
        if ($user['uname'] === $username) {
            // User found, send the secret question as a JSON response
            echo json_encode([
                'success' => true,
                'question' => $user['secret_question']
            ]);
            exit();
        }
    }

    // User not found, return an error message
    echo json_encode(['success' => false, 'message' => 'User not found']);
}

getSecretQuestion();

