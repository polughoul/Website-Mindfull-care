<?php
session_start();

if (isset($_SESSION['user'])) {
    header('Location: home.php');
    exit();
}

$title="Log in";
ob_start();
?>
<form class="form" action="../../scripts_php/script_login.php" method="post" id = "form">
    <h1 class="form_title">Log in</h1>
    <label class="form_label" for="uname" id = "uname-label">
        <span class = "strong_bold">Username:<span class="required">*</span></span>
        <input class="form_input" type="text" id="uname" name="uname">
    </label>

    <label class="form_label" for="password" id = "password-label">
        <span class = "strong_bold">Password:<span class="required">*</span></span>
        <input class="form_input" type="password" id="password" name="password">
    </label>
    <span id="error" class="error"></span><br>
    <span id = "required-fields" class = "required-fields"><span class="required">*</span> Required</span><br>
    <input class="form_submit_btn login_submit_btn" type="submit" value="Log in" id = "submit-button">
    <button id="forgot-password-button" class = "forgot-password">Forgot password? Answer your secret question</button>

    <div id="reset-password-fields" class = "reset-password-fields">
    </div>
</form>

<?php
$script='<script defer src="../../js/scriptLogin.js"></script>';
$children = ob_get_clean();
include("../../templates/layouts/layout.php");
?>

