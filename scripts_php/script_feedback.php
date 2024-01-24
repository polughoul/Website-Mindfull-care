<?php
/**
 * Start a new session or resume the existing session.
 */
session_start();

/**
 * Check if a user is logged in.
 *
 * Outputs a JSON response indicating whether a user is logged in or not.
 */
function checkLoginStatus(): void
{
    // Check if the 'user' key is set in the session
    if (isset($_SESSION['user'])) {
        // Output JSON indicating the user is logged in
        echo json_encode(['loggedIn' => true]);
    } else {
        // Output JSON indicating the user is not logged in
        echo json_encode(['loggedIn' => false]);
    }
}

checkLoginStatus();

