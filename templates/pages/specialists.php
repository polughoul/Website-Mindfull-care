<?php
session_start();
$title="Our specialists";
ob_start();
?>
<section>
    <h1 class="page-title">Our psychologists</h1>
    <p class="text_home">All of our therapists are highly trained professionals,
        with extensive experience working for both self-employed and government agencies.
        We present the services of these specialists because their knowledge is tested annually at advanced training courses and, of course,
        on the basis of numerous positive feedback from people who have undergone therapy. </p>
    <hr class="separator">
    <ul class="list_psycho">
        <li class="pic_psycho_container">
            <img class="pic_psycho" src="https://www.ghc.cz/source/Koutná_dermatolog.jpg" alt = "photo">
            <p class="name_psycho">prof. MUDr. Anna Novakova, Ph.D.</p>
        </li>
        <li class="pic_psycho_container">
            <img class="pic_psycho" src="https://www.ghc.cz/source/Vaško_neurolog.jpg" alt = "photo">
            <p class="name_psycho">MUDr. Petr Smid</p>
        </li>
        <li class="pic_psycho_container">
            <img class="pic_psycho" src="https://www.ghc.cz/source/brisuda_1200px.png" alt = "photo">
            <p class="name_psycho">MUDr. Tomáš Marek</p>
        </li>
        <li class="pic_psycho_container">
            <img class="pic_psycho" src="https://www.ghc.cz/source/moravcova_foto.jpg" alt = "photo">
            <p class="name_psycho">MUDr. Petra Svobodová, Ph.D.</p>
        </li>
        <li class="pic_psycho_container">
            <img class="pic_psycho" src="https://www.ghc.cz/source/placha_foto.png" alt = "photo">
            <p class="name_psycho">MUDr. Barbora Havelková</p>
        </li>
        <li class="pic_psycho_container">
            <img class="pic_psycho" src="https://www.ghc.cz/source/Havlíčková.jpg" alt = "photo">
            <p class="name_psycho">MUDr. Eva Staneck</p>
        </li>
        <li class="pic_psycho_container">
            <img class="ded_psycho" src="../../templates/layouts/ded.jpg" alt = "photo">
            <p class="name_psycho">Stariy alkash</p>
        </li>
    </ul>
</section>
<?php
$children = ob_get_clean();
include("../../templates/layouts/layout.php");
?>

