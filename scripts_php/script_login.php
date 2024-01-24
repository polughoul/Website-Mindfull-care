<?php
session_start();

/**
 * Checks the user credentials.
 *
 * @param array  $users    The array of users.
 * @param string $uname    The username.
 * @param string $password The user's password.
 *
 * @return bool Returns true if the credentials are valid, false otherwise.
 */
function checkCredentials($users, $uname, $password): bool
{
    foreach ($users as $user) {
        if ($user['uname'] === $uname && password_verify($password, $user['password'])) {
            // Record user information in the session
            $_SESSION['user'] = $user;
            return true;
        }
    }
    return false;
}

/**
 * Loads users from the json file.
 *
 * @return array Returns an array of users. Returns an empty array in case of loading errors.
 */
function loadUsers(): array
{
    $users = json_decode(file_get_contents('users.json'), true);
    return $users ? $users : [];
}

/**
 * Main logic for handling POST requests for authentication.
 */
function handleAuthentication(): void
{
    // Check the request method
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $uname = trim($_POST['uname']);
        $password = $_POST['password'];

        // Load users from the json file
        $users = loadUsers();

        // Check user credentials
        $loggedIn = checkCredentials($users, $uname, $password);

        // Return the result in JSON format
        if (!$loggedIn) {
            echo json_encode(['success' => false, 'message' => 'Invalid username or password.']);
        } else {
            echo json_encode(['success' => true, 'message' => 'Login successful!']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    }
}

handleAuthentication();

