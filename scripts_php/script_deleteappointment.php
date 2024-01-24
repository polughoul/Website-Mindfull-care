<?php
/**
 * Start a new session or resume the existing session.
 */
session_start();

/**
 * Delete appointment for a logged-in user.
 *
 * Checks the request method, user login status, and resets appointment information for the logged-in user.
 * Outputs a JSON response indicating the success of the operation.
 */
function deleteAppointmentInfo(): void
{
    $response = ['success' => false];

    // Check if the request method is POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Check if the user is logged in
        if (isset($_SESSION['user']['uname'])) {
            // Extract the username from the session
            $username = $_SESSION['user']['uname'];

            // Load user data
            $usersData = json_decode(file_get_contents('users.json'), true);

            // Find the user and reset appointment information
            foreach ($usersData as &$user) {
                if ($user['uname'] === $username) {
                    unset($user['date_appointment']);
                    unset($user['time_appointment']);
                    unset($user['doctor']);

                    // Update the user's info in the session
                    $_SESSION['user'] = $user;
                    $response['user_info'] = $user;

                    break;
                }
            }

            // Save the updated data
            file_put_contents('users.json', json_encode($usersData));

            // Set success flag to true
            $response['success'] = true;
        } else {
            // Set an error message if the user is not logged in
            $response['error'] = 'User is not logged in';
        }
    } else {
        // Set an error message for an invalid request method
        $response['error'] = 'Invalid request method';
    }

    // Send a JSON response
    echo json_encode($response);
}

deleteAppointmentInfo();
