<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title><?php echo $title; ?></title>

    <link rel="stylesheet" href="../../styles/reset.css" type="text/css">
    <link rel="stylesheet" href="../../styles/style.css" type="text/css">


    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <?php
        if (isset($script)) {
            echo $script;
        }
    ?>
    <script defer src="../../js/scriptLogout.js"></script>
</head>

<body>
    <?php include('../components/header.php'); ?>

    <main class="main">
        <?php echo $children; ?>
    </main>

    <?php include('../components/footer.php'); ?>
</body>

</html>