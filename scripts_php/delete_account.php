<?php
/**
 * Delete the logged-in user and end the session.
 *
 * This function reads the users.json file, finds the logged-in user,
 * removes the user from the data array, updates the users.json file,
 * destroys the user session, and returns a JSON-encoded success response.
 *
 * @return void This function outputs the JSON-encoded response.
 */
function deleteUserAndEndSession(): void
{
    // Start the user session
    session_start();

    // Check if the user is logged in
    if (!isset($_SESSION['user'])) {
        echo json_encode(['success' => false, 'error' => 'User is not logged in.']);
        exit;
    }

    // Load user data from the users.json file
    $data = json_decode(file_get_contents('users.json'), true);

    // Find the logged-in user and remove them from the array
    foreach ($data as $index => $user) {
        if ($user['uname'] == $_SESSION['user']['uname']) {
            array_splice($data, $index, 1);
            break;
        }
    }

    // Save the updated data back to the users.json file
    file_put_contents('users.json', json_encode($data));

    // End the user session
    session_destroy();

    // Output the JSON-encoded success response
    echo json_encode(['success' => true]);
}

deleteUserAndEndSession();
