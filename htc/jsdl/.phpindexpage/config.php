<?php


$env[show_hidden_files] = 0;  # if true, show hidden files
$env[show_symlink] = 0;       # if true, symbolic links are considered

$env[load_index_file] = 0;    # if true, load a index page.

$env[index_file] = "index.php";

$env[row_highlight] = 1;      # if true, highlight the row pointed by cursor

$env[return_home] = "";       # return to this url if click 'return to home'
$env[lang] = "English";       # language
$env[field_mtime] = 1;        # last modification time field
$env[field_atime] = 0;        # last access time field
$env[field_ctime] = 0;        # last change time field
$env[field_user]  = 0;        # user id of owner field
$env[field_group] = 0;        # group id of owner field
$env[field_coloring] = 0;     # colored fields
$env[human_time_format] = 1;  # more human-readable time format
$env[change_on] = 0;          # upload, make directory features are valid
$env[exact_size] = 0;         # exact size in byte
$env[upload_on] = 0;          # upload feature
$env[upload_max_size] = 0;    # upload file max. size in bytes. disabled if 0
$env[disk_free_info] = 0;     # if true, display disk free size information

$env[show_projectname] = false;   # if true, show project name in the tail of page

$env[color_highlight] = "#eeeeee";  # highlighted row
$env[color_bg]        = "#ffffff";  # page background
$env[color_th]        = "#cccccc";  # table heading
$env[color_td]        = "#eeeeee";  # table data

if ($env[url_path]) $env[img_path] = "$env[url_path]/img";
else $env[img_path] = "$env[script_prefix]img";
$env[icon_dir]   = "$env[img_path]/dir.gif";
$env[icon_file]  = "$env[img_path]/file.gif";
$env[icon_link]  = "$env[img_path]/link.gif";
$env[icon_top]   = "$env[img_path]/top.gif";
$env[icon_wdir]  = "$env[img_path]/wdir.gif";
$env[icon_wfile] = "$env[img_path]/wfile.gif";

?>
