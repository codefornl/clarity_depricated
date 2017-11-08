<?php

ini_set("error_reporting", E_ALL);
ini_set("display_errors", 1);

require '../vendor/autoload.php';

use Intervention\Image\ImageManager;

$manager = new ImageManager(["driver" => "imagick"]);
$image = $manager->make($_GET["url"]);
$image->fit((int) $_GET["width"], $_GET["height"]);
exit($image->response('jpg'));

//cache it?
