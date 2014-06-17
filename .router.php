<?php
//Name this file .routing.php and place in webroot
//originally written by Ralph Schindler http://news.php.net/php.internals/53870

//If using zf, this is a convenient place to define the dev environment
define('APPLICATION_ENV', 'development');

//If the file exists or is an obvious static resource, do nothing by returning false.
//Route all other requests through index.php.
if ( preg_match('/\.(?:png|jpg|jpeg|gif|ico)$/', $_SERVER['REQUEST_URI']) ||
file_exists(__DIR__ . '/' . $_SERVER['REQUEST_URI']) ) {
return false;
} else {
include_once 'index.php';
}