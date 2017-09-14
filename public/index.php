<?php
    $uri = $_SERVER["REQUEST_URI"];
    $uri_parts = array_values(array_filter(explode("/", explode("?", $uri)[0])));
    $cbase = $uri_parts[0];
    
    // check if cbase exists
    
    // if exists, then show search
    
    // otherwise, show main page
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="/css/reset.css">
        <link rel="stylesheet" href="/css/base.css">
    </head>
    <body>
        <h1><?= $cbase ?> CBase</h1>
        <h2>Search Engine for Curated Collections of Projects</h2>
        <?php if ($cbase) { ?>
            <form>
                <input type="text" name="q">
                <button>Search CBase <?= $cbase ?></button>
            </form>
        <?php } else { ?>
            <form method="post">
                <h1>Create a new CBase</h1>
                CBase name: <input type="text"><br>
                Admin e-mail: <input type="email"><br>
                <button>Create CBase</button>
            </form>
        <?php } ?>
    </body>
</html>
