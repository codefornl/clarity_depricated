<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="/css/reset.css">
        <link rel="stylesheet" href="/css/base.css">
        <meta charset="UTF-8">
        <meta name='viewport' content='width=320,initial-scale=1,user-scalable=0'>
    </head>
    <body>
        <nav>
            <ul>
                <li><a href="">more info</a></li>
            </ul>
        </nav>
        <header>
            <?php if (!empty($cbase["image"])) { ?>
                <img src="<?=$cbase["image"]?>" style="height: 4em">
            <?php } else { ?>
                <h1><?= $cbase["name"] ?> CBase</h1>
                <h2>search engine for curated collections of projects</h2>
            <?php } ?>
        </header>
        <main>
            <form method="post">
                <h1>Add a project</h1>
                <input type="hidden" name="token" value="<?=$_GET["token"]?>">
                <input type="hidden" name="cbase_id" value="<?=$cbase["id"]?>">
                Name: <input name="name" type="text" value="<?=$_POST["name"]?>"><br>
                Description: <textarea name="description" value="<?=$_POST["description"]?>"></textarea><br>
                Image URI: <input name="image" type="text" value="<?=$_POST["image"]?>"><br>
                Category: <input name="category" type="text" value="<?=$_POST["category"]?>"><br>
                Type: <input name="type" type="text" value="<?=$_POST["type"]?>"><br>
                Country: <input name="country" type="text" value="<?=$_POST["country"]?>"><br>
                Organisation: <input name="organisation" type="text" value="<?=$_POST["organisation"]?>"><br>
                Website URL: <input name="website" type="text" value="<?=$_POST["website"]?>"><br>
                Download URI: <input name="download" type="text" value="<?=$_POST["download"]?>"><br>
                License: <input name="license" type="text" value="<?=$_POST["license"]?>"><br>
                <button>Add project</button>
            </form>
        </main>
        <footer>
            <a href="/<?=$cbase["name"]?>?token=<?=$_GET["token"]?>">cancel and go back</a>
        </footer>
    </body>
</html>