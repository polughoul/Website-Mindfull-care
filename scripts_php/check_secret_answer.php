<?php
/**
 * Check the secret answer for a given username.
 *
 * This function reads the users.json file, finds the user with the
 * specified username, checks if the provided answer matches the user's
 * secret answer, and returns a JSON-encoded success or error response.
 *
 * @return void This function outputs the JSON-encoded response.
 */
function checkSecretAnswer(): void
{
    // Set the content type header to JSON
    header('Content-Type: application/json');

    // Get the username and answer from the request
    $data = json_decode(file_get_contents('php://input'), true);
    $username = trim($data['uname']);
    $answer = trim($data['answer']);

    // Load the users data from the users.json file
    $usersData = json_decode(file_get_contents('users.json'), true);

    // Find the user with the given username
    foreach ($usersData as $user) {
        if ($user['uname'] === $username) {
            // User found, check the secret answer
            if ($user['secret_answer'] === $answer) {
                // Answer is correct, return success
                echo json_encode(['success' => true]);
            } else {
                // Answer is incorrect, return an error message
                echo json_encode(['success' => false, 'message' => 'Incorrect answer']);
            }
            exit();
        }
    }

    // User not found, return an error message
    echo json_encode(['success' => false, 'message' => 'User not found']);
}

checkSecretAnswer();

