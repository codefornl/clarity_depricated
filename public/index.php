<?php
    //ini_set("error_reporting", E_ALL);
    //ini_set("display_errors", 1);

    $uri = $_SERVER["REQUEST_URI"];
    $uri_parts = array_values(array_filter(explode("/", explode("?", $uri)[0])));
    
    $cbase_name = $uri_parts[0];
    
    $config = include(__DIR__ . "/../private/config.php");
    
    $pdo = new PDO(
        "mysql:host={$config["db"]["hostname"]};dbname={$config["db"]["dbname"]};charset=utf8mb4",
        $config["db"]["username"],
        $config["db"]["password"]
    );
    
    define("MODE_USER", 1);
    define("MODE_ADMIN", 2);
    
    if ($cbase_name) { // cbase search page
        $stmt = $pdo->prepare("SELECT * FROM cbases WHERE name = :name LIMIT 1");
        $stmt->execute(["name" => $cbase_name]);
        $cbase = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($cbase) {
            $mode = MODE_USER;
            if (!empty($_GET["token"]) && password_verify($_GET["token"], $cbase["token_encrypted"])) {
                $mode = MODE_ADMIN;
            }
        } else {
            header("HTTP/1.1 404 File Not Found");
            exit("<h1>404 File Not Found</h1>");
        }
    } else { // main page
        if (!empty($_POST["cbase_name"]) && !empty($_POST["admin_email"])) {
            $cbase_name = $_POST["cbase_name"];
            $stmt = $pdo->prepare("SELECT * FROM cbases WHERE name = :name LIMIT 1");
            $stmt->execute(["name" => $cbase_name]);
            $cbase = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($cbase) {
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
                $stmt = $pdo->prepare("INSERT INTO cbases SET name = :name, admin_email = :admin_email, token_encrypted = :token_encrypted");
                $stmt->execute([
                    "name" => $cbase_name,
                    "admin_email" => $admin_email,
                    "token_encrypted" => $token_encrypted
                ]);
                
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
                <h1><?= $cbase["name"] ?> CBase</h1>
                <h2>Search Engine for Curated Collections of Projects</h2>
        </header>
        <main>
        <?php if ($cbase) { ?>
            <form class="searchbar">
                <input type="text" name="q"><br>
                <button>Search CBase <?= $cbase["name"] ?></button>
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
