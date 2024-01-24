<?php
/**
 * Set the content type of the response to JSON.
 */
header('Content-Type: application/json');

/**
 * Change user password based on the provided information.
 *
 * This function receives a JSON payload containing the username and new password.
 * It validates the password and updates the hashed password for the corresponding
 * user in the users.json file.
 */
function changeUserPassword(): void
{
    // Get the username and new password from the request
    $data = json_decode(file_get_contents('php://input'), true);
    $username = trim($data['uname']);
    $password = $data['password'];

    // Load the users data
    $usersData = json_decode(file_get_contents('users.json'), true);

    // Find the user with the given username
    foreach ($usersData as $index => $user) {
        if ($user['uname'] === $username) {
            // User found, check the password
            if (strlen($password) < 6) {
                echo json_encode(['success' => false, 'message' => 'Invalid password. Password should be at least 6 characters long.']);
                exit();
            }
            if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d!@#$%^&*()-+]+$/', $password)) {
                echo json_encode(['success' => false, 'message' => 'Invalid password. Password should contain at least one letter and one number and no spaces.']);
                exit();
            }

            // Hash the new password and update user data
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $usersData[$index]['password'] = $hashed_password;
            file_put_contents('users.json', json_encode($usersData));

            // Send a success response
            echo json_encode(['success' => true]);
            exit();
        }
    }

    // User not found, return an error message
    echo json_encode(['success' => false, 'message' => 'User not found']);
}


changeUserPassword();

