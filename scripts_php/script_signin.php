<?php

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize input data
    $fname = trim($_POST['fname']);
    $sname = trim($_POST['sname']);
    $date = $_POST['date'];
    $email = $_POST['email'];
    $tel = trim($_POST['tel']);
    $uname = trim($_POST['uname']);
    $password = $_POST['password'];
    $repassword = $_POST['repassword'];
    $secret_question = trim($_POST['secret_question']);
    $secret_answer = trim($_POST['secret_answer']);

    // Load user data from JSON file
    $users = json_decode(file_get_contents('users.json'), true);

    validateName($fname, 'Invalid first name.');
    validateName($sname, 'Invalid surname.');
    validateDate($date, 'Please select your date of birth.');
    validateEmail($email, 'Invalid email address.');
    validatePhoneNumber($tel, 'Invalid phone number format. Please use +xxx xxx xxx xxx.');
    validateUsername($uname, 'Invalid username.');
    validatePasswordLength($password, 6, 'Invalid password. Password should be at least 6 characters long.');
    validatePasswordFormat($password, 'Invalid password. Password should contain at least one letter and one number and no spaces.');
    validatePasswordMatch($password, $repassword, 'Passwords do not match.');
    validateText($secret_question, 5, 50, 'Invalid secret question.');
    validateText($secret_answer, 4, 50, 'Invalid secret answer.');
    validateUniqueField($users, 'email', $email, 'Email is already taken. Please use a different one.');
    validateUniqueField($users, 'uname', $uname, 'Username is already taken. Please choose a different one.');

    // Create user data array
    $userData = [
        'fname' => $fname,
        'sname' => $sname,
        'date' => $date,
        'email' => $email,
        'tel' => $tel,
        'uname' => $uname,
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'isAdmin' => false,
        'isBlocked' => false,
        'secret_question' => $secret_question,
        'secret_answer' => $secret_answer
    ];

    // Add user data to the users array
    $users[] = $userData;

    // Save updated users array to JSON file
    file_put_contents('users.json', json_encode($users));

    // Return success message
    echo json_encode(['success' => true, 'message' => 'Registration successful!']);
} else {
    // Return error message for invalid request method
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}

/**
 * Validate and handle errors for a name field.
 *
 * Returns `true` if the length and format match the requirements, and `false` otherwise.
 *
 * @param string $value The name value being validated.
 * @param string $errorMessage The error message to display if validation fails.
 */
function validateName(string $value, string $errorMessage): void
{
    if (strlen($value) < 2 || strlen($value) > 24 || !preg_match('/^[A-Za-z]+$/', $value)) {
        echo json_encode(['success' => false, 'message' => $errorMessage]);
        exit();
    }
}

/**
 * Validate and handle errors for a date field.
 *
 * Returns `true` if the date is provided, and `false` otherwise.
 *
 * @param string $value The date value being validated.
 * @param string $errorMessage The error message to display if validation fails.
 */
function validateDate($value, $errorMessage): void
{
    if (!$value) {
        echo json_encode(['success' => false, 'message' => $errorMessage]);
        exit();
    }
}

/**
 * Validate and handle errors for an email field.
 *
 * Returns `true` if the email format is valid, and `false` otherwise.
 *
 * @param string $value The email value being validated.
 * @param string $errorMessage The error message to display if validation fails.
 */
function validateEmail($value, $errorMessage): void
{
    if (!$value || !filter_var($value, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => $errorMessage]);
        exit();
    }
}

/**
 * Validate and handle errors for a phone number field.
 *
 * Returns `true` if the phone number format is valid, and `false` otherwise.
 *
 * @param string $value The phone number value being validated.
 * @param string $errorMessage The error message to display if validation fails.
 */
function validatePhoneNumber($value, $errorMessage): void
{
    if (!$value || !preg_match('/^\+\d{3}\s\d{3}\s\d{3}\s\d{3}$/', $value)) {
        echo json_encode(['success' => false, 'message' => $errorMessage]);
        exit();
    }
}

/**
 * Validate and handle errors for a username field.
 *
 * Returns `true` if the length and format match the requirements, and `false` otherwise.
 *
 * @param string $value The username value being validated.
 * @param string $errorMessage The error message to display if validation fails.
 */
function validateUsername($value, $errorMessage): void
{
    if (strlen($value) < 1 || strlen($value) > 24 || !preg_match('/^[A-Za-z0-9]+$/', $value)) {
        echo json_encode(['success' => false, 'message' => $errorMessage]);
        exit();
    }
}

/**
 * Validate and handle errors for a password field.
 *
 * Returns `true` if the length and format match the requirements, and `false` otherwise.
 *
 * @param string $value The password value being validated.
 * @param int $minLength The minimum length required for the password.
 * @param string $errorMessage The error message to display if validation fails.
 */
function validatePasswordLength($value, $minLength, $errorMessage): void
{
    if (strlen($value) < $minLength) {
        echo json_encode(['success' => false, 'message' => $errorMessage]);
        exit();
    }
}

/**
 * Validate and handle errors for a password format.
 *
 * Returns `true` if the format is valid, and `false` otherwise.
 *
 * @param string $value The password value being validated.
 * @param string $errorMessage The error message to display if validation fails.
 */
function validatePasswordFormat($value, $errorMessage): void
{
    if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d!@#$%^&*()-+]+$/', $value)) {
        echo json_encode(['success' => false, 'message' => $errorMessage]);
        exit();
    }
}

/**
 * Validate and handle errors for matching passwords.
 *
 * Returns `true` if the passwords match,
 */
function validatePasswordMatch($password, $repassword, $errorMessage): void
{
    if ($password !== $repassword) {
        echo json_encode(['success' => false, 'message' => $errorMessage]);
        exit();
    }
}

/**
 * Validate and handle errors for a text field.
 *
 * Returns `true` if the length and format match the requirements, and `false` otherwise.
 *
 * @param string $value The text value being validated.
 * @param int $minLength The minimum length required for the text.
 * @param int $maxLength The maximum length allowed for the text.
 * @param string $errorMessage The error message to display if validation fails.
 */
function validateText($value, $minLength, $maxLength, $errorMessage): void
{
    if (strlen($value) < $minLength || strlen($value) > $maxLength || !preg_match('/^[A-Za-z0-9\s]+$/', $value)) {
        echo json_encode(['success' => false, 'message' => $errorMessage]);
        exit();
    }
}
/**
 * Validate and handle errors for a unique field.
 *
 * Returns `true` if the field is unique, and `false` otherwise.
 *
 * @param array $users An array of existing users.
 * @param string $field The field to check for uniqueness.
 * @param string $value The value being validated.
 * @param string $errorMessage The error message to display if validation fails.
 */
function validateUniqueField($users, $field, $value, $errorMessage): void
{
    foreach ($users as $user) {
        if ($user[$field] === $value) {
            echo json_encode(['success' => false, 'message' => $errorMessage]);
            exit();
        }
    }
}
