<?php
/**
 * Start the session to retrieve user information.
 */
session_start();

/**
 * Retrieve and return user data based on the current session.
 *
 * This function reads the users.json file and searches for the user with the
 * same username as the one stored in the current session. If found, it returns
 * the user data as a JSON response; otherwise, it returns an error message.
 */
function getUserData(): void
{
    // Load user data from the users.json file
    $data = json_decode(file_get_contents('users.json'), true);

    // Search for the user with the same username as in the session
    foreach ($data as $user) {
        if ($user['uname'] == $_SESSION['user']['uname']) {
            // User found, send user data as a JSON response
            echo json_encode($user);
            exit();
        }
    }

    // User not found, return an error message
    echo json_encode(['error' => 'User not found']);
}

getUserData();

