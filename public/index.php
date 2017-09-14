<?php
    //ini_set("error_reporting", E_ALL);
    //ini_set("display_errors", 1);

    $uri = $_SERVER["REQUEST_URI"];
    $uri_parts = array_values(array_filter(explode("/", explode("?", $uri)[0])));
    
    $cbase_name = $uri_parts[0];
    
    $db_file = __DIR__ ."/../private/cbases_db.json";
    
    $db = json_decode(file_get_contents($db_file), true);
    
    if ($cbase_name) { // cbase search page    
        if (array_key_exists($cbase_name, $db["cbases"])) {
            if (!empty($_GET["token"]) && password_verify($_GET["token"], $db["cbases"][$cbase_name]["token_encrypted"])) {
                echo "ADMIN MODE!";
                // add project page, edit project page
                // search page, results page or details page
            } else {
                echo "USER MODE!";
                // search page, results page or details page
            }
        } else {
            header("HTTP/1.1 404 File Not Found");
            exit("<h1>404 File Not Found</h1>");
        }
    } else { // main page
        if (!empty($_POST["cbase_name"]) && !empty($_POST["admin_email"])) {
            $cbase_name = $_POST["cbase_name"];
            if (isset($db["cbases"][$cbase_name])) {
                header("HTTP/1.1 409 Conflict");
                exit("<h1>409 Conflict</h1><p>Existing CBase name. Please choose another name.</p>");
            } else {
                $admin_email = $_POST["admin_email"];
                $token = "";
                $token_alphabet = array_merge(range('A','F'), range(0,9));
                for ($i = 0; $i < 40; ++$i) {
                    $token .= $token_alphabet[array_rand($token_alphabet)];
                }
                $token_encrypted = password_hash($token, PASSWORD_DEFAULT);
                
                $db["cbases"][$cbase_name] = [
                    "name" => $cbase_name,
                    "admin_email" => $admin_email,
                    "token_encrypted" => $token_encrypted
                ];
                
                file_put_contents($db_file, json_encode($db));
                
                $email_title = "{$cbase_name} cbase admin permalink";
                $email_body = "
                    Hi, your cbase \"{$cbase_name}\" has been created. Click on the link to add projects to your cbase:
                    
                    http://www.cbase.eu/{$cbase_name}?token={$token}
                ";
                mail($_POST["admin_email"], $email_title, $email_body);
            }
        }
    }
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
