<?php
    $uri = $_SERVER["REQUEST_URI"];
    $uri_parts = array_values(array_filter(explode("/", explode("?", $uri)[0])));
    $cbase = $uri_parts[0];
    
    if (!empty($_POST["cbase_name"]) && !empty($_POST["admin_email"])) {
        // generate token
        // register cbase with admin e-mail and check token does not exist (store tokens blowfish)
        mail($_POST["admin_email"], "cbase admin link", "cbase created; here is your admin link");
        exit('thanks'); // replace with template
    }
    
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
        <header>
        <h1><?= $cbase ?> CBase</h1>
        <h2>Search Engine for Curated Collections of Projects</h2>
        </header>
        <main>
        <?php if ($cbase) { ?>
            <form>
                <input type="text" name="q">
                <button>Search CBase <?= $cbase ?></button>
            </form>
        <?php } else { ?>
            <form method="post">
                <h1>Create a new CBase</h1>
                CBase name: <input name="cbase_name" type="text"><br>
                Admin e-mail: <input name="admin_email" type="email"><br>
                <button>Create CBase</button>
            </form>
        <?php } ?>
        </main>
        <footer>
            <a href="https://github.com/codefornl/cbase">CBase on Github</a>
        </footer>
    </body>
</html>
