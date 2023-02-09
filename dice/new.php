<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    include 'core/main.php';
    $getFromIncludes->includes();
    ?>

    <body class="sb-nav-fixed">
        <?php $getFromIncludes->topnav(); ?>
        <div id="layoutSidenav">
            <?php $getFromIncludes->sidenav(); ?>
            <div id="layoutSidenav_content">
                <!--Content of display page-->
                <main>
                    
                </main>
                <?php $getFromIncludes->footer();?>
            </div>
        </div>
    </body>
</body>

</html>