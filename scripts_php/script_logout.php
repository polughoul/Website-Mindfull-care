<?php
/**
 * Start a new session or resume the existing session.
 */
session_start();

/**
 * Log the user out of the account.
 *
 * Unsets the user session data.
 */
function logout(): void
{
    unset($_SESSION['user']);

    // Return success message in JSON format
    echo json_encode(['success' => true]);
}

logout();

