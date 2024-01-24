<?php
/**
 * Start a new session or resume the existing session.
 */
session_start();

/**
 * Change user password based on the provided information.
 *
 * This function checks if the provided username matches the username
 * stored in the session. It then validates and updates the password
 * for the corresponding user in the users.json file.
 */
function changeUserPassword(): void
{
    // Check if the provided username matches the username in the session
    if ($_POST['uname'] !== $_SESSION['user']['uname']) {
        echo json_encode(['success' => false, 'error' => 'Please enter the correct username.']);
        exit;
    }

    $password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate the password length
    if (strlen($password) < 6) {
        echo json_encode(['success' => false, 'error' => 'Invalid password. Password should be at least 6 characters long.']);
        exit;
    }

    // Validate the password format
    if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d!@#$%^&*()-+]+$/', $password)) {
        echo json_encode(['success' => false, 'error' => 'Invalid password. Password should contain at least one letter and one number and no spaces.']);
        exit;
    }

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo json_encode(['success' => false, 'error' => 'Passwords do not match.']);
        exit;
    }

    // Load user data from the users.json file
    $data = json_decode(file_get_contents('users.json'), true);
    $userFound = false;

    // Iterate through user data to find the matching user
    foreach ($data as &$user) {
        if ($user['uname'] == $_POST['uname']) {
            // Update the user's password
            $user['password'] = password_hash($password, PASSWORD_DEFAULT);
            $userFound = true;
            break;
        }
    }

    // Check if the user was found
    if (!$userFound) {
        echo json_encode(['success' => false, 'error' => 'User not found.']);
        exit;
    }

    // Save the updated user data back to the users.json file
    file_put_contents('users.json', json_encode($data));

    // Send a success response
    echo json_encode(['success' => true]);
}


changeUserPassword();

