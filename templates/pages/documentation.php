<?php
session_start();
$title = "Documentation";
ob_start();
?>
<div class="documentation">
    <h1 class="doc-title">Documentation</h1>
    <h2 class="doc-subtitle">Description</h2>
    <a href="https://docs.google.com/document/d/18SOxPrWtxNI_taZTqVkM6vaOLa6kyk4E/edit?usp=drive_link&ouid=105479446922398807574&rtpof=true&sd=true">Full task</a>
    <h2 class="doc-subtitle">User manual</h2>
    <a href="https://docs.google.com/document/d/1VoA4Uq_6o9QmfqCuucWFy1xLkDp2hqge/edit?usp=drive_link&ouid=105479446922398807574&rtpof=true&sd=true">Description of website functionality</a>
    <a href="https://docs.google.com/document/d/1o6ne2GQDARSpmFZxFkVvOwq9fixFAnNG/edit?usp=drive_link&ouid=105479446922398807574&rtpof=true&sd=true">Web UI samples</a>
    <h2 class="doc-subtitle">Developer manual</h2>
    <a href="https://docs.google.com/document/d/1kC4f9zh_iPYXbd0_9D0kOQ58BzI4GdSR/edit?usp=drive_link&ouid=105479446922398807574&rtpof=true&sd=true">Description of the main features of the program</a>
    <a href="../../doxygen/html/files.html">Generated documentation</a>
</div>
<?php
$children = ob_get_clean();
include("../../templates/layouts/layout.php");
?>

