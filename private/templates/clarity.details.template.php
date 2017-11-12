<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Clarity Market Place - Maidstone Council</title>
    <link href="/css/foundation.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet" type="text/css">
    <link href="/css/additions.css" rel="stylesheet" type="text/css">
</head>
<body class="layout">

    <header class="main-header layout__main-header">
        <a href="/">
            <img src="/svg/clarity-marketplace-logo.svg" alt="Clarity marketplace" class="main-header__logo">
        </a>
    </header>

    <main class="main-content layout__main-content">

        <form class="searchbar layout__searchbar">
            <input type="text" class="searchbar__input" placeholder="Search eGovernment applications">
            <button class="searchbar__button"><img src="/svg/searchbar-icon.svg"></button>
        </form>

        <div class="layout__row">

            <a href="/<?=$cbase["name"]?>" class="back-link layout__back">&larr; Back to overview</a>

            <article class="project-detail layout__project-detail">
                <div class="project-detail__image" style="background-image: url(http://img.codefor.nl?url=<?=urlencode($project["image"])?>&height=426&width=640)">
                    <div class="project-detail__overlay">
                        <h1 class="project-detail__title"><?=$project["name"]?></h1>
                        <h2 class="project-detail__location"><?=$project["organisation"]?> (<?=$project["country"]?>)</h2>
                    </div>
                </div>
                <div class="wrapper__text">
                    <p class="introduction"><?=$project["teaser"]?></p>

                    <p><?=$project["description"]?></p>

                    <p><a href="<?=$project["website"]?>"><?=$project["website"]?></a></p>
                </div>
            </article>

            <aside class="project-meta layout__project-meta">

                <div class="project-meta__item">
                    <h3 class="project-meta__header">Category</h3>
                    <p class="project-meta__text"><?=$project["category"]?></p>
                </div>

                <div class="project-meta__item">
                    <h3 class="project-meta__header">Type</h3>
                    <p class="project-meta__text"><?=$project["type"]?></p>
                </div>

                <div class="project-meta__item">
                    <h3 class="project-meta__header">Tools</h3>
                    
<?php foreach ($project["tools"] as $tool) : ?>
                    <a href="#" class="project-meta__link">iTouchVision</a>
<?php endforeach; ?>

                </div>

                <div class="project-meta__curator">
                    <div class="curator">
                        <img src="<?=$project["contact_image"]?>" class="curator__avatar">
                        <div class="curator__contact">
                            <h3 class="curator__name"><?=$project["contact_name"]?></h3>
                            <div class="curator__badge">contact</div>
                            <a href="mailto:<?=$project["contact_email"]?>" class="curator__email"><?=$project["contact_email"]?></a>
                        </div>
                    </div>
                </div>

            </aside>

        </div>
    </main>
</body>
</html>