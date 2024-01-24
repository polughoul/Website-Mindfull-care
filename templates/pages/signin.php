<?php
session_start();

if (isset($_SESSION['user'])) {
    header('Location: home.php');
    exit();
}
$title="Sign In";
ob_start();
?>
<form class="form" action="../../scripts_php/script_signin.php" method="POST" id="form">
    <h1 class="form_title">Sign in</h1>
    <label class="form_label" for="fname"><span class = "strong_bold">Please enter your name:<span class="required">*</span></span>
        <span class = "tips_registration">min:2 max:24 no special characters, spaces and numbers</span>
        <input class="form_input"  type="text" id="fname" name="fname" required>
    </label>

    <label class="form_label" for="sname"><span class = "strong_bold">Please enter your surname:<span class="required">*</span></span>
        <span class = "tips_registration">min:2 max:24 no special characters, spaces and numbers</span>
        <input class="form_input"  type="text" id="sname" name="sname" required>
    </label>
    <label class="form_label" for="date"><span class = "strong_bold">Please enter your date of birthday:<span class="required">*</span></span>
        <input class="form_input" type="date" id="date" name="date" max="2013-12-31" min="1910-01-01" required>
    </label>
    <label class="form_label" for="email"><span class = "strong_bold">Please enter your e-mail:<span class="required">*</span></span>
        <span class = "tips_registration">example:ivan_ivanov@gmail.com</span>
        <input class="form_input" type="email" id="email" name="email" required>
    </label>
    <label class="form_label" for="tel"><span class = "strong_bold">Please enter your phone number:<span class="required">*</span></span>
        <span class = "tips_registration">example:+420 123 456 789</span>
        <input class="form_input" type="tel" id="tel" name="tel" required>
    </label>
    <label class="form_label" for="uname"><span class = "strong_bold">Create username:<span class="required">*</span></span>
        <span class = "tips_registration">min:1 max:24 no special characters and spaces</span>
        <input class="form_input" type="text" id="uname" name="uname" required>
    </label>
    <label class="form_label" for="password"><span class = "strong_bold">Create password:<span class="required">*</span></span>
        <span class = "tips_registration">min:6 at least one letter and one number, no spaces</span>
        <input class="form_input" type="password" id="password" name="password" required>
    </label>
    <label class="form_label" for="repassword"><span class = "strong_bold">Confirm password:<span class="required">*</span></span>
        <input class="form_input" type="password" id="repassword" name="repassword" required>
    </label>
    <label class="form_label" for="secret_question"><span class = "strong_bold">Enter a secret question:<span class="required">*</span></span>
        <span class = "tips_registration">This question will be used to reset your password. min:5 max:50. Only  letters, numbers, and spaces</span>
        <input class="form_input" type="text" id="secret_question" name="secret_question" required>
    </label>
    <label class="form_label" for="secret_answer"><span class = "strong_bold">Enter the answer to your secret question:<span class="required">*</span></span>
        <span class = "tips_registration">Remember this answer. It will be used to reset your password. min:4 max:50. Only  letters, numbers, and spaces</span>
        <input class="form_input" type="text" id="secret_answer" name="secret_answer" required>
    </label>
    <span id="error" class="error"></span><br>
    <span id = "required-fields" class = "required-fields"><span class="required">*</span> Required</span><br>
    <input class="form_submit_btn login_submit_btn" type="button" value="Sign in" id="submit-button">
</form>
<span id="registration_success_message" class = "registration_success_message">You have successfully registered! Now you can log in.</span>
<?php
$script= '<script defer src="../../js/scriptSignin.js"></script>';
$children = ob_get_clean();
include("../../templates/layouts/layout.php");
?>

