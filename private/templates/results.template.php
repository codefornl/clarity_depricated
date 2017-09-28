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
<?php if ($mode === MODE_ADMIN) { ?>
                <li><a href="/<?=$cbase["name"]?>/add?token=<?=$_GET["token"]?>">+add project</a></li>
<?php } ?>
                <li><a href="">more info</a></li>
            </ul>
        </nav>
        <?php if (!$cbase) { ?>
            <div style="height: 400px; background: url(https://pbs.twimg.com/profile_banners/753880345683034112/1468589964/1500x500) center right no-repeat; background-size: cover"></div>
        <?php } ?>
        <header>
            <a href="/<?=$cbase["name"]?>">
                <?php if (!empty($cbase["image"])) { ?>
                    <img src="<?=$cbase["image"]?>" style="height: 4em">
                <?php } else { ?>
                    <h1><?= $cbase["name"] ?></h1>
                    <h2>CBase, search engine for curated collections</h2>
                <?php } ?>
            </a>
        </header>
        <main>
        <?php if ($cbase) { ?>
            <form class="searchbar" style="margin-bottom: 4em">
                <input type="text" name="q" value="<?=$_GET["q"]?>"><br>
                <button>Search</button>
            </form>
        <?php } else { ?>
            <style>
                form {
                    background: #ccc;
                    padding: 20px;
                    margin-bottom: 20px;
                }
            </style>
            <form method="post">
                <h1>Create a new CBase</h1>
                CBase name: <input name="cbase_name" type="text"><br>
                Admin e-mail: <input name="admin_email" type="email"><br>
                <button>Create CBase</button>
            </form>
        <?php } ?>
        <style>
            .result {
                width: 90%;
                text-align: left;
                padding: 1em;
                border-bottom: 1px solid #eee;
            }
            .result .name {
                font-size: 1.2em;
            }
            .result p {
                margin-top: 0.4em;
                line-height: 1.2em;
            }
            .result img {
                max-height: 100px;
                max-width: 100px;
            }
            .result .type,
            .result .country,
            .result .category {
                display: inline-block;
                background: #0098CA;
                color: white;
                font-weight: 100;
                font-size: 0.8em;
                padding: 0.2em;
                border-radius: 0.2em;
                margin: 0.4em 0.2em 0 0 ;
            }
        </style>
        <?php foreach ($rs as $r) { ?>
            <div class="result">
                <div style="height: 200px; width: 100px; float: right; margin: 1em">
                    <img src="<?=$r["image"]?>">
                </div>
                <div class="info">
                    <a class="name" href="<?=$r["website"]?>"><?=$r["name"]?></a><br>
                    <p><?=str_replace("\n", "<br>", $r["description"])?></p>
                    <a href="?q=<?=strtolower($r["category"])?>"><span class="category"><?=$r["category"]?></span></a>
                    <a href="?q=<?=strtolower($r["type"])?>"><span class="type"><?=$r["type"]?></span></a>
                    <a href="?q=<?=strtolower($r["country"])?>"><span class="country"><?=$r["country"]?></span></a>
                </div>
                <div style="clear: both"></div>
            </div>
        <?php } ?>
        <?php foreach ($cbases as $cbase) { ?>
            <div style="display: inline-block; width: 240px; margin: 20px; padding: 10px; border: 1px solid gray">
                <div style="padding: 10px; height: 120px">
                    <img src="<?=$cbase["image"]?>" style="max-height: 120px; max-width: 100%">
                </div>
                <div style="background: #ccc; font-size: 1.4em; line-height: 2em; height: 2em; overflow: hidden">
                    <a class="name" href="/<?=$cbase["name"]?>"><?=$cbase["name"]?></a><br>
                </div>
                <div style="clear: both"></div>
            </div>
        <?php } ?>
        </main>
        <footer>
            <a href="https://github.com/codefornl/cbase">CBase on Github</a>
        </footer>
    </body>
</html>