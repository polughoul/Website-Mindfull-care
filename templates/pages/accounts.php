<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: home.php');
    exit();
}
$title = "My Account";
ob_start();
?>
    <section class = "section-profile">

        <h1 class = "title-profile">Profile</h1>
        <form class = "form_profile" id="upload-avatar-form" enctype="multipart/form-data">
            <img class = "img_profile" id="avatar-img" src="" alt="User avatar">
            <input class = "load_img" type="file" id="avatar" name="avatar" accept="image/*">
            <button class = "button_img" type="submit">Upload Avatar</button>
            <span id="error" class="error"></span><br>
        </form>
        <div class = "user-info" id="user-info">
            <p class = "list_profile">First Name: <span class = "list_profile" id="fname"></span> <button class="edit-btn" data-field="fname">Edit</button></p>
            <p class = "list_profile">Last Name: <span class = "list_profile" id="sname"></span> <button class="edit-btn" data-field="sname">Edit</button></p>
            <p class = "list_profile">Date of birth: <span class = "list_profile" id="date"></span> <button class="edit-btn" data-field="date">Edit</button></p>
            <p class = "list_profile">Email: <span class = "list_profile" id="email"></span> <button class="edit-btn" data-field="email">Edit</button></p>
            <p class = "list_profile">Telephone: <span class = "list_profile" id="tel"></span> <button class="edit-btn" data-field="tel">Edit</button></p>
            <p class = "list_profile">Username: <span class = "list_profile" id="uname"></span> <button class="edit-btn" data-field="uname">Edit</button></p>
            <p class = "list_profile">Password:
                <label class = "list_profile" for="password"></label>
                <input class = "input_profile" type = "password" id = "password"></p>
            <button class = "delete-button-profile" id="delete-account">Delete Account</button>
        </div>
        <h2 class = "title-profile" id = "title-reset-password">Reset Password</h2>
        <form class = "form_profile" id="reset-password-form" action="../../scripts_php/reset_password_profile.php" method="POST">
            <label class = "list_profile" for="uname-reset">Username:<span class="required">*</span></label><br>
            <input class = "input_profile" type="text" id="uname-reset" name="uname" required><br>
            <label class = "list_profile" for="new_password">New Password:<span class="required">*</span></label><br>
            <input class = "input_profile" type="password" id="new_password" name="new_password" required><br>
            <label class = "list_profile" for="confirm_password">Confirm New Password:<span class="required">*</span></label><br>
            <input class = "input_profile" type="password" id="confirm_password" name="confirm_password" required><br>
            <input class = "button-reset" type="submit" value="Reset Password">
        </form>
    </section>


<?php
$script= '<script defer src="../../js/profile.js"></script>';
$children = ob_get_clean();
include("../../templates/layouts/layout.php");
?>