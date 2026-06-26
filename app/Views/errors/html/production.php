<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex">

    <title>Whoops!</title>

    <style type="text/css">
        <?= preg_replace('#[\r\n\t ]+#', ' ', file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'debug.css')) ?>
    </style>
</head>
<body>

    <div class="container text-center">
        <h1 class="headline">CRITICAL ERROR CAUGHT</h1>
        <p class="lead">
            <?php 
            if (isset($exception)) {
                echo $exception->getMessage() . '<br><br>';
                echo nl2br($exception->getTraceAsString());
            } else {
                echo "Unknown error occurred.";
            }
            ?>
        </p>
    </div>

</body>

</html>
