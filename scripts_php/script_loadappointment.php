<?php
/**
 * Start a new session or resume the existing session.
 */
session_start();

/**
 * Process user appointment information.
 *
 * Validates the user session, updates the user's appointment details,
 * and saves the updated user data to the users.json file.
 */
function processAppointment(): void
{
    // Initialize the response array
    $response = ['success' => false];

    // Check if the request method is POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Log the receipt of the POST request
        error_log('Received POST request');

        // Check if the user is logged in
        if (isset($_SESSION['user']['uname'])) {
            // Log that the user is logged in
            error_log('User is logged in');

            // Get the username from the session
            $username = $_SESSION['user']['uname'];
            // Get user data from users.json
            $usersData = json_decode(file_get_contents('users.json'), true);

            // Iterate through user data to find the user and update appointment details
            foreach ($usersData as &$user) {
                if ($user['uname'] === $username) {
                    $user['date_appointment'] = $_POST['date_app'];
                    $user['time_appointment'] = $_POST['time_app'];
                    $user['doctor'] = $_POST['doctor'];

                    // Add the user's info to the response
                    $response['user'] = $user;
                    $_SESSION['user'] = $user;
                    break;
                }
            }

            // Save the updated user data
            file_put_contents('users.json', json_encode($usersData));

            // Set success to true in the response
            $response['success'] = true;
        } else {
            // Log that the user is not logged in
            error_log('User is not logged in');
            // Set an error message in the response
            $response['error'] = 'User is not logged in';
        }
    } else {
        // Log that the request method is invalid
        error_log('Invalid request method');
        // Set an error message in the response
        $response['error'] = 'Invalid request method';
    }

    // Output the response as JSON
    echo json_encode($response);
}


processAppointment();

