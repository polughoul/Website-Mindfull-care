<?php
/**
 * Start a new session or resume the existing session.
 */
session_start();

/**
 * Check if a user is logged in and provide user information if available.
 *
 * Checks for the presence of user information in the session and sets
 * the response indicating whether the user is logged in and includes
 * user information if available.
 */
function checkLoggedInUser(): void
{
    $response = ['loggedIn' => false];

    // Check if user information is present in the session
    if (isset($_SESSION['user']['uname'])) {
        // Set the loggedIn flag to true
        $response['loggedIn'] = true;
        // Include user information in the response
        $response['user_info'] = $_SESSION['user'];
    }

    // Send a JSON response
    echo json_encode($response);
}

checkLoggedInUser();
