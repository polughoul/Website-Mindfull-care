<?php
/**
 * Start a new session or resume the existing session.
 */
session_start();

/**
 * Upload and set user avatar.
 *
 * Moves the uploaded avatar file to the target directory,
 * updates the user's avatar URL in the users.json file,
 * and returns success or error messages in JSON format.
 */
function uploadAvatar(): void
{
    // Set the target directory for avatar uploads
    $targetDir = "uploads/avatars/";

    // Get the base name of the uploaded file
    $targetFile = $targetDir . basename($_FILES["avatar"]["name"]);
    $targetFileUrl = "/~stasiand/Semestralka_zwa/semestralka/scripts_php/" . $targetDir . basename($_FILES["avatar"]["name"]);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if the uploaded file is an image
    $check = getimagesize($_FILES["avatar"]["tmp_name"]);
    if ($check === false) {
        echo json_encode(['success' => false, 'error' => 'File is not an image.']);
        exit;
    }

    // Check if the file already exists
    if (file_exists($targetFile)) {
        echo json_encode(['success' => false, 'error' => 'Sorry, file already exists.']);
        exit;
    }

    // Check the file size
    if ($_FILES["avatar"]["size"] > 500000) {
        echo json_encode(['success' => false, 'error' => 'Sorry, your file is too large.']);
        exit;
    }

    // Allow only specific file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo json_encode(['success' => false, 'error' => 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.']);
        exit;
    }

    // Attempt to move the uploaded file
    if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $targetFile)) {
        // Update user avatar URL in users.json
        $data = json_decode(file_get_contents('users.json'), true);
        foreach ($data as &$user) {
            if ($user['uname'] == $_SESSION['user']['uname']) {
                $user['avatar'] = $targetFileUrl;
                break;
            }
        }
        file_put_contents('users.json', json_encode($data));

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Sorry, there was an error uploading your file.']);
    }
}

uploadAvatar();
