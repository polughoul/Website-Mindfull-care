<?php
session_start();
$title = "Feedback";
ob_start();
?>
<div id = "feedback-section">
    <form class="form feedback_form" action="../../scripts_php/script_loadfeedback.php" method="post" id="feedback-form">
        <h1 class="form_title">Leave Your Feedback</h1>
        <label class="form_label" for="feedback">
            <span>Your Feedback:<span class="required">*</span></span>
            <textarea class="form_input" id="feedback" name="feedback" rows="4" required></textarea>
        </label>
        <span id = "required-fields" class = "required-fields"><span class="required">*</span> Required</span><br>
        <span id="error" class="error"></span><br>
        <input class="form_submit_btn feedback_submit_btn" type="submit" value="Send Feedback" id="submit-button">
        <input type="hidden" id="username" value="<?php echo $_SESSION['user']['uname']; ?>">
    </form>
    <span id="registration-text" class="registration-text">To leave a feedback, <a class = "link_home" href = "signin.php">register</a> or <a class = "link_home" href = "login.php">log in</a> to your account.</span>
    <span id = "banned_text" class = "banned_text">You have been banned. Please write to the administrator <strong class="strong_bold"><a href="mailto:andreystasiuk1488@gmail.com">andreystasiuk1488@gmail.com</a></strong></span>
    <hr class = "separator2" id = "separator2">
    <div id = "feedbacks" class="feedbacks">
    </div>
    <div id="pagination-buttons">
        <button id="prev-button" class="pagination-button">Previous</button>
        <button id="next-button" class="pagination-button">Next</button>
    </div>
</div>


<?php
$script = '<script defer src="../../js/scriptFeedback.js"></script>';
$children = ob_get_clean();
include("../../templates/layouts/layout.php");
?>
