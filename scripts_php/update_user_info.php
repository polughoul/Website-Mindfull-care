<?php
/**
 * Start a new session or resume the existing session.
 */
session_start();

/**
 * Update user information based on the received field and value.
 *
 * Validates the received field and value, checks for duplicates in the users.json file,
 * updates the user's information, and returns success or error messages in JSON format.
 */
function updateUserInformation(): void
{
    // Get the raw JSON data from the request
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    // Extract field and value from the received data
    $field = $data['field'];
    $value = trim($data['value']);

    // Get user data from users.json
    $users = json_decode(file_get_contents('users.json'), true);

    // Validate and handle errors for different fields
    switch ($field) {
        case 'fname':
        case 'sname':
            validateName($value, 'Invalid ' . ($field === 'fname' ? 'first name' : 'surname') . '.');
            break;

        case 'date':
            validateDate($value, 'Please select your date of birth.');
            break;

        case 'email':
            validateEmail($value, 'Invalid email address.');
            break;

        case 'tel':
            validatePhoneNumber($value, 'Invalid phone number format. Please use +xxx xxx xxx xxx.');
            break;

        case 'uname':
            validateUsername($value, 'Invalid username.');
            break;

        default:
            // Add additional field validations if needed
            break;
    }

    // Check for duplicate email or username
    validateUniqueField($users, $field, $value, ucfirst($field) . ' is already taken. Please choose a different one.');

    // Update user information
    foreach ($users as &$user) {
        if ($user['uname'] == $_SESSION['user']['uname']) {
            $user[$field] = $value;
            if ($field === 'uname') {
                $_SESSION['user']['uname'] = $value;
            }
            break;
        }
    }

    // Save the updated user data to users.json
    file_put_contents('users.json', json_encode($users));

    // Return success message
    echo json_encode(['success' => true, 'message' => ucfirst($field) . ' updated successfully!']);
}

/**
 * Validate and handle errors for the name field.
 *
 * Checks if the name has a valid length and contains only letters.
 *
 * @param string $name The name to be validated.
 * @param string $errorMessage The error message to be displayed if validation fails.
 */
function validateName($name, $errorMessage): void
{
    if (strlen($name) < 2 || strlen($name) > 24 || !preg_match('/^[A-Za-z]+$/', $name)) {
        echo json_encode(['success' => false, 'message' => $errorMessage]);
        exit();
    }
}

/**
 * Validate and handle errors for the date field.
 *
 * Checks if a valid date is selected.
 *
 * @param string $date The date to be validated.
 * @param string $errorMessage The error message to be displayed if validation fails.
 */
function validateDate($date, $errorMessage): void
{
    if (!$date) {
        echo json_encode(['success' => false, 'message' => $errorMessage]);
        exit();
    }
}

/**
 * Validate and handle errors for the email field.
 *
 * Checks if a valid email address is provided.
 *
 * @param string $email The email address to be validated.
 * @param string $errorMessage The error message to be displayed if validation fails.
 */
function validateEmail($email, $errorMessage): void
{
    if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => $errorMessage]);
        exit();
    }
}

/**
 * Validate and handle errors for the phone number field.
 *
 * Checks if a valid phone number format is provided.
 *
 * @param string $phoneNumber The phone number to be validated.
 * @param string $errorMessage The error message to be displayed if validation fails.
 */
function validatePhoneNumber($phoneNumber, $errorMessage): void
{
    if (!$phoneNumber || !preg_match('/^\+\d{3}\s\d{3}\s\d{3}\s\d{3}$/', $phoneNumber)) {
        echo json_encode(['success' => false, 'message' => $errorMessage]);
        exit();
    }
}

/**
 * Validate and handle errors for the username field.
 *
 * Checks if the username has a valid length and contains only letters and numbers.
 *
 * @param string $username The username to be validated.
 * @param string $errorMessage The error message to be displayed if validation fails.
 */
function validateUsername($username, $errorMessage): void
{
    if (strlen($username) < 1 || strlen($username) > 24 || !preg_match('/^[A-Za-z0-9]+$/', $username)) {
        echo json_encode(['success' => false, 'message' => $errorMessage]);
        exit();
    }
}

/**
 * Validate if the field value is unique among users.
 *
 * Checks if the provided field value is unique among existing users.
 *
 * @param array $users The array containing user data.
 * @param string $field The field to be checked for uniqueness.
 * @param string $value The value to be checked for uniqueness.
 * @param string $errorMessage The error message to be displayed if the value is not unique.
 */
function validateUniqueField($users, $field, $value, $errorMessage): void
{
    foreach ($users as $user) {
        if ($field === 'email' && $user[$field] === $value) {
            echo json_encode(['success' => false, 'message' => $errorMessage]);
            exit();
        }

        if ($field === 'uname' && $user[$field] === $value) {
            echo json_encode(['success' => false, 'message' => $errorMessage]);
            exit();
        }
    }
}

updateUserInformation();

