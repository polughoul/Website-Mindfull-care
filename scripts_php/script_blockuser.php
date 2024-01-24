<?php
/**
 * Start a new session or resume the existing session.
 */


session_start();
/**
 * Block a user by setting their blocked status to true.
 *
 * Checks if the user is an admin, extracts the username from the request data,
 * loads user data, finds the specified user, and sets their blocked status to true.
 * Outputs a JSON response indicating the success of the operation.
 */
function blockUser(): void
{
    // Decode the input data from the request
    $data = json_decode(file_get_contents('php://input'), true);

    // Check if the logged-in user is an admin and the necessary data is present
    if (isset($_SESSION['user']['uname']) && isset($data['username']) && $_SESSION['user']['isAdmin']) {
        $username = $data['username'];

        // Load the users data from the users.json file
        $usersData = json_decode(file_get_contents("users.json"), true);

        // Find the user with the specified username and set 'isBlocked' to true
        foreach ($usersData as &$userData) {
            if ($userData['uname'] === $username) {
                $userData['isBlocked'] = true;
                break;
            }
        }
        // Save the updated user data back to the users.json file
        file_put_contents("users.json", json_encode($usersData));

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid request']);
    }
    exit();
}

blockUser();

