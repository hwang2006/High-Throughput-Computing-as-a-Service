<?php

/************************************************************************/
/* phpIndexPage: Web-base filesystem browser                            */
/* =========================================                            */
/*                                                                      */
/* Written by Sangwan Kim (sangwan@hpcnet.ne.kr)                        */
/* http://phpindexpage.sourceforge.net                                  */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/*                                                                      */
/* Please read LICENSE.txt                                              */
/************************************************************************/

$env[inc_path] = ".";
$env[url_path] = ".";
include("$env[inc_path]/common.php");

## configuration (refer config.dist.php)
# $env[show_hidden_files] = 1;  # if true, show hidden files also
# $env[show_symlink] = 1;       # if true, symbolic links are considered
# $env[load_index_file] = 1;    # if true, load a index page.
# $env[index_file] = "index.html";
# $env[row_highlight] = 1;      # if true, highlight the row pointed by cursor
# $env[exts] = array('xml');
# $env[return_home] = "/";      # return to this url if click 'return to home'

phpIndexPage();

?>
