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
        <h1>CBase</h1>
        <h2>Search Engine for Curated Collections of Projects</h2>
    </body>
</html>
