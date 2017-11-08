<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Clarity Market Place - Maidstone Council</title>
    <link href="css/foundation.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <link href="css/additions.css" rel="stylesheet" type="text/css">
</head>
<body class="layout">

    <header class="main-header layout__main-header">
        <a href="/">
            <img src="https://tydelyk.nl/clarity/svg/clarity-marketplace-logo.svg" alt="Clarity marketplace" class="main-header__logo">
        </a>
    </header>

    <main class="main-content layout__main-content">

        <!--
        <form class="searchbar layout__searchbar">
            <input type="text" class="searchbar__input" placeholder="Search eGovernment applications">
            <button class="searchbar__button"><img src="svg/searchbar-icon.svg"></button>
        </form>
        -->

<?php foreach ($cbases as $cbase) { ?>

        <div class="layout__row">

            <div class="layout__list-meta">

                <div class="list-summary">
                    <h2 class="list-summary__title"><?=$cbase["name"]?></h2>
                    <div class="list-summary__count">14 projects</div>
                    <p class="list-summary__description"><?=$cbase["description"]?></p>
                    <div class="list-summary__curator">
                        <div class="curator">
                            <img src="<?=$cbase["image"]?>" class="curator__avatar">
                            <div class="curator__contact">
                                <h3 class="curator__name">Ingrid Thylin</h3>
                                <div class="curator__badge">curator</div>
                                <a href="#" class="curator__email">e.mail@example.com</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="layout__project-list">
                
<?php
    $count = 0;
    foreach ($projects as $project) {
        if ($project["cbase_id"] === $cbase["id"] && $count < 5) {
            $count++;
?>

                <a href="detail.html">
                    <div class="project layout__project-list-item">
                        <img src="/image.php?url=<?=urlencode($project["image"])?>&height=426&width=640" class="project__image">
                        <div class="project__meta">
                            <div class="project__summary">
                                <h3 class="project__title"><?=$project["name"]?></h3>
                                <h4 class="project__location">Maidstone Council</h4>
                            </div>
                            <div class="project__tools">
                                <img src="svg/tools-icon.svg" class="project__tools-icon">
                                <span class="project__tools-count">1 tool</span>
                            </div>
                        </div>
                    </div>
                </a>
                
<?php
        } // if
    } // foreach
?>

                <a href="detail.html">
                    <div class="project layout__project-list-item">
                        <img src="" class="project__image">
                        <div class="project__meta">
                            <div class="project__summary">
                                <h3 class="project__title">MORE INFO &gt;</h3>
                                <h4 class="project__location"></h4>
                            </div>
                            <div class="project__tools">
                                <img src="svg/tools-icon.svg" class="project__tools-icon">
                                <span class="project__tools-count">16 total</span>
                            </div>
                        </div>
                    </div>
                </a>

            </div>
        </div>
        
        <hr>
        
<?php } ?>

    </main>
</body>
</html>