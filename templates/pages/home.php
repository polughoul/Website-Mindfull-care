<?php
    session_start();
    $title="Home";
    ob_start();
?>

<section class="section">
    <h1 class="page-title">Welcome to MindfulCare</h1>
    <p class="text_home">Welcome to the website of Mindfulcare organization. Our organization consists of highly qualified professionals from the Czech Republic.
        Our organization decided to unite the efforts of these professionals to help people from the Czech Republic in an organized way. <br>Offline sessions take place in our office located at Zenklova 8/78, 180 00 Praha 8-Palmovka.</p>
    <article class="photo_office">
        <label for="desktop"></label>
        <input checked type="radio" name="respond" id="desktop">
        <div id="slider">
            <input checked type="radio" name="slider" id="switch1">
            <input type="radio" name="slider" id="switch2">
            <input type="radio" name="slider" id="switch3">

            <div id="slides">
                <div id="overflow">
                    <div class="image">
                        <article><img src="../../images/slider_photo1.jpg" alt = "office"></article>
                        <article><img src="../../images/slider_photo2.jpg" alt = "office"></article>
                        <article><img src="../../images/slider_photo3.jpg" alt = "office"></article>
                    </div>
                </div>
            </div>

            <div id="active">
                <label for="switch1"></label>
                <label for="switch2"></label>
                <label for="switch3"></label>
            </div>
        </div>
    </article>
    <article>
        <span class="pros"><strong class="strong_bold">Why should you contact us?</strong></span>
        <ul class="list_home">
            <li class="list_fields_home">We offer the services of highly qualified professionals with extensive experience in various fields of psychology and psychotherapy. Each of our specialists undergoes annual training courses.</li>
            <li class="list_fields_home">Convenient and quick appointment. You do not need to write separately to a particular specialist (but you can certainly contact them for any questions), you can quickly and easily sign up through the form on the site.</li>
            <li class="list_fields_home">The first three sessions are free of charge.</li>
            <li class="list_fields_home">Various bonuses, when you receive which you will be allocated a discount of <strong class="strong_bold">10% to 30%</strong></li>
            <li class="list_fields_home">Meetings are possible both offline and online.</li>
        </ul>

        <p class="text_home"><strong class="strong_red">We also now have an 80% discount for all Ukrainian refugees.</strong></p>
        <p class="text_home">For any technical questions write to <strong class="strong_bold"><a href="mailto:mindfullcare@gmail.com">mindfullcare@gmail.com</a></strong> or call to the number: <strong class="strong_bold"><a href="tel:+420723448753">+420 723 448 753</a></strong></p>
        <p class="text_home">In order to <a class = "link_home"  href = "appointment.php">make an appointment</a> for a therapy session or <a class = "link_home" href = "feedback.php">leave a feedback</a> you need to <a class = "link_home" href = "signin.php">register</a> or if you are already registered you need to <a class = "link_home" href = "login.php">log in</a> to your account. If you want to change your personal data you can do it on your <a class = "link_home" href = "accounts.php">account page</a>.</p>
    </article>
</section>

<?php
$children = ob_get_clean();
include("../../templates/layouts/layout.php");
?>
