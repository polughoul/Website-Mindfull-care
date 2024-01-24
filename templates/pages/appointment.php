<?php
session_start();
$title="Create appointment";
ob_start();
?>

<form class="form" action = "../../scripts_php/script_loadappointment.php" method="post" id = "appointment-form">
    <h1 class="form_title">You can make an appointment here!</h1>

    <label class="form_label" for="date_app"><span>Please choose a date, time and doctor:<span class="required">*</span></span></label>
    <input class="form_input" type="date" id="date_app" name="date_app" min="<?= date('Y-m-d') ?>" max="2024-06-30" required>
    <label class="form_label" for="time_app"></label>
    <select class = "form_select" id="time_app" name="time_app" required>
        <option value="" selected disabled hidden>Choose time</option>
        <option value="10:00" >10:00</option>
        <option value="11:00" >11:00</option>
        <option value="12:00" >12:00</option>
        <option value="13:00" >13:00</option>
        <option value="14:00" >14:00</option>
        <option value="15:00" >15:00</option>
        <option value="16:00" >16:00</option>
        <option value="17:00" >17:00</option>
        <option value="18:00" >18:00</option>
    </select>
    <label class="form_label" for="doctor"></label>
    <select class="form_select" id = "doctor" name = "doctor">
        <option value="" selected disabled hidden>Choose doctor</option>
        <option value="prof. MUDr. Anna Novakova">prof. MUDr. Anna Novakova</option>
        <option value="MUDr. Petr Smid">MUDr. Petr Smid</option>
        <option value="MUDr. Tomas Marek">MUDr. Tomáš Marek</option>
        <option value="MUDr. Petra Svobodova, Ph.D.">MUDr. Petra Svobodová, Ph.D.</option>
        <option value="MUDr. Barbora Havelkova">MUDr. Barbora Havelková</option>
        <option value="MUDr. Eva Staneck">MUDr. Eva Staneck</option>
    </select>

    <span id = "required-fields" class = "required-fields"><span class="required">*</span> Required</span><br>
    <input class="form_submit_btn login_submit_btn" type="submit" value="Confirm appointment request" id = "submit-button"><br>

</form>
<span id="registration-text" class = "registration-text">To make an appointment, <a class = "link_home" href = "signin.php">register</a> or <a class = "link_home" href = "login.php">log in</a> to your account</span>
<div id="content">
</div>
<?php
$script= '<script defer src="../../js/scriptAppointment.js"></script>';
$children = ob_get_clean();
include("../../templates/layouts/layout.php");
?>

