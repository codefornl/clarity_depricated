<?php
    ini_set("error_reporting", E_PARSE);
    ini_set("display_errors", 1);
    
    define("MODE_USER", 1);
    define("MODE_ADMIN", 2);
    
    $config = include(__DIR__ . "/../private/config.php");
    $pdo = new PDO(
        "mysql:host={$config["db"]["hostname"]};dbname={$config["db"]["dbname"]};charset=utf8mb4",
        $config["db"]["username"],
        $config["db"]["password"]
    );
    
    $uri = $_SERVER["REQUEST_URI"];
    $uri_parts = array_values(array_filter(explode("/", explode("?", $uri)[0])));
    $cbase_name = str_replace(["%20", "_"], " ", $uri_parts[0]);
    $project_id = (int) $uri_parts[1];
    if ($cbase_name) { // cbase search page
        $sql = "SELECT * FROM cbases WHERE name = :name LIMIT 1";
        $params = ["name" => $cbase_name];
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $cbase = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($cbase) {
            $mode = MODE_USER;
            if (!empty($_GET["token"]) && password_verify($_GET["token"], $cbase["token_encrypted"])) {
                $mode = MODE_ADMIN;
            }
            if ($mode === MODE_ADMIN && $uri_parts[1] === "add") {
                if (!empty($_POST) && !empty($_POST["name"])) {
                    $sql = "
                        INSERT INTO projects
                        SET
                            cbase_id = {$cbase["id"]},
                            name = :name,
                            description = :description,
                            image = :image,
                            type = :type,
                            country = :country,
                            category = :category,
                            organisation = :organisation,
                            website = :website,
                            download = :download,
                            license = :license
                    ";
                    $stmt = $pdo->prepare($sql);
                    $rs = $stmt->execute([
                        "name" => $_POST["name"],
                        "description" => $_POST["description"],
                        "image" => $_POST["image"],
                        "type" => $_POST["type"],
                        "country" => $_POST["country"],
                        "category" => $_POST["category"],
                        "organisation" => $_POST["organisation"],
                        "website" => $_POST["website"],
                        "download" => $_POST["download"],
                        "license" => $_POST["license"]
                    ]);
                    exit("<h1>201 Created</h1><p>Klik <a href='/{$cbase["name"]}?token={$_GET["token"]}'>hier</a> om verder te gaan</p>");
                } else {
                    include(__DIR__ . "/../private/templates/add.template.php");
                    exit();
                }
            } else {
                if ($project_id) {
                    $sql = "SELECT * FROM projects WHERE id = {$project_id} LIMIT 1";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute($params);
                    $project = $stmt->fetch(PDO::FETCH_ASSOC);
                    if (strpos($_SERVER["HTTP_ACCEPT"], "application/json") !== false || $_GET["type"] === "json") {
                        header("Content-type: application/json");
                        exit(json_encode([
                            "links" => [
                                "first" => null,
                                "previous" => null,
                                "self" => "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]",
                                "next" => null,
                                "last" => null,
                            ],
                            "project" => $rs
                        ]));
                    } else {
                        include(__DIR__ . "/../private/templates/clarity.details.template.php");
                        exit();
                    }
                } else {
                    $sql = "SELECT * FROM projects WHERE cbase_id = {$cbase["id"]} ";
                    $params = [];
                    if ($_GET["q"]) {
                        $sql .= "
                            AND (
                                description LIKE :q
                                OR country LIKE :q
                                OR name LIKE :q
                                OR type LIKE :q
                                OR category LIKE :q
                            ) ";
                        $params["q"] = "%" . $_GET["q"] . "%";
                    }
                    $sql .= " ORDER BY name ASC";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute($params);
                    $rs = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    if (strpos($_SERVER["HTTP_ACCEPT"], "application/json") !== false || $_GET["type"] === "json") {
                        header("Content-type: application/json");
                        exit(json_encode([
                            "links" => [
                                "first" => null,
                                "previous" => null,
                                "self" => "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]",
                                "next" => null,
                                "last" => null,
                            ],
                            "results" => $rs
                        ]));
                    } else {
                        include(__DIR__ . "/../private/templates/clarity.results.template.php");
                        exit();
                    }
                }
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
                exit("<h1>409 Conflict</h1><p>Existing CBase name. Please choose another name. Click <a href='/'>here</a> to go back.</p>");
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
                
                $permalink =  str_replace(" ", "%20", "http://www.cbase.eu/{$cbase_name}?token={$token}");
                
                $headers  = "MIME-Version: 1.0\r\n";
                $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
                $headers .= "From: no-reply@cbase.eu\r\n" .
                            "X-Mailer: PHP/" . phpversion();
                $email_title = "{$cbase_name} cbase admin permalink";
                $email_body = "
                    <html><body>
                    <h1>CBase \"{$cbase_name}\" created</h1>
                    <p>Hi, your cbase \"{$cbase_name}\" has been created. Click on the link to add projects to your cbase:</p>
                    <p><a href=\"{$permalink}\">{$permalink}</a></p>
                    </body></html>
                ";
                mail($_POST["admin_email"], $email_title, $email_body, $headers);
                header("HTTP/1.1 201 Created");
                exit("<h1>201 Created</h1><p>Please check your e-mail. Click <a href='/'>here</a> to go back.</p>");
            }
        } else {
            $stmt = $pdo->prepare("SELECT id, name, admin_name, admin_email, image, description FROM cbases");
            $stmt->execute();
            $cbases = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stmt = $pdo->prepare("SELECT * FROM projects");
            $stmt->execute();
            $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    include(__DIR__ . "/../private/templates/clarity.list.template.php");