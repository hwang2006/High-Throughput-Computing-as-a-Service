<?php

/************************************************************************/
/* phpIndexPage: Web-base filesystem browser                            */
/* =========================================                            */
/* Please read LICENSE.txt                                              */
/************************************************************************/

# some common path variables
$env[php_self] = $_SERVER['PHP_SELF'];

$env[script_filename] = $_SERVER['SCRIPT_FILENAME'];

# current script's filename without .php extension
$env[script_name] = ereg_replace("^.*\/(.*)\.php$", "\\1", $env[php_self]);

# prefix of script path
$env[script_prefix] = ereg_replace("(\/.+\/).*$", "\\1", $env[php_self]);

# script path in file system
$env[script_path] = ereg_replace("(^\/.*)\/.*$", "\\1", $env[script_filename]);

/*
echo("php_self=$env[php_self]<br>");
echo("script_filename=$env[script_filename]<br>");
echo("script_name=$env[script_name]<br>");
echo("script_prefix=$env[script_prefix]<br>");
echo("script_path=$env[script_path]<br>");
*/
# php_self=/~sangwan/phpindexpage/indexpage.php
# script_filename=/home/sangwan/public_html/phpindexpage/indexpage.php
# script_name=indexpage
# script_prefix=/~sangwan/phpindexpage/
# script_path=/home/sangwan/public_html/phpindexpage

include("$env[inc_path]/config.php");
include("$env[inc_path]/function.php");

?>
