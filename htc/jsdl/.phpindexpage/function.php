<?php

/************************************************************************/
/* phpIndexPage: Web-base filesystem browser                            */
/* =========================================                            */
/* Please read LICENSE.txt                                              */
/************************************************************************/

# Get the current date and time.
# Return an associative array, keys of the array are
# {year, month, day, hour, min, sec}.
function CurrentTime() {
  $d = date("Y-m-d H:i:s");
  $date[year]  = (int)substr($d, 0, 4);
  $date[month] = (int)substr($d, 5, 2);
  $date[day]   = (int)substr($d, 8, 2);
  $date[hour]  = (int)substr($d, 11, 2);
  $date[min]   = (int)substr($d, 14, 2);
  $date[sec]   = (int)substr($d, 17, 2);
  return $date;
}

# print the content of an array
function PrintArray($array, $name='array') {
  $keys = array_keys($array);
  $len = sizeof($keys);
  for ($i = 0; $i < $len; $i++) {
    $key = $keys[$i];
    echo("$name.$key='$array[$key]'<br>\n");
  }
}
# print the content of an array recursively
function PrintArrayR($array, $name='array') {
  $keys = array_keys($array);
  $len = sizeof($keys);
  for ($i = 0; $i < $len; $i++) {
    $key = $keys[$i];
    if (is_array($array[$key])) PrintArrayR($array[$key], "$name.$key");
    else echo("$name.$key='$array[$key]'<br>\n");
  }
}

# display an error message and terminate program
function Error($msg, $go_back=1) {
  $msg = ereg_replace("\n", "\\n", $msg);
  echo("<script>\n");
  echo("alert(\"$msg\")\n");
  if ($go_back) echo("history.go(-1)");
  echo("</script>\n");
  exit;
}

# format byte data (reused from phpMyAdmin)
function FormatByteDown($value, $limes=6, $comma=0) {
  $dh           = pow(10, $comma);
  $li           = pow(10, $limes);
  $return_value = $value;

  $byteUnits    = array('Bytes', 'KB', 'MB', 'GB');
  $unit         = $byteUnits[0];

  if ($value >= $li*1000000) {
    $value = round($value/(1073741824/$dh))/$dh;
    $unit  = $byteUnits[3];
  } else if ($value >= $li*1000) {
    $value = round($value/(1048576/$dh))/$dh;
    $unit  = $byteUnits[2];
  } else if ($value >= $li) {
    $value = round($value/(1024/$dh))/$dh;
    $unit  = $byteUnits[1];
  }

  if ($unit != $byteUnits[0]) {
    $return_value = number_format($value, $comma, '.', ',');
  } else {
    $return_value = number_format($value, 0, '.', ',');
  }

  return array($return_value, $unit);
}

# get the stat of a file
function FileStat($file) {
  global $env;

  $stat = stat("$file");
# if (!$stat) Error("Can't stat file '$file'");
# if (is_link($file)) return array('type'=>'l');

  # attributes by name
  $stat[inode] = $stat[1];   # inode
  $stat[uid]   = $stat[4];   # user id of owner
  $stat[gid]   = $stat[5];   # group id of owner
  $stat[size]  = $stat[7];   # size in bytes
  $stat[atime] = $stat[8];   # time of last access
  $stat[mtime] = $stat[9];   # time of last modification
  $stat[ctime] = $stat[10];  # time of last change

  ####################################
  # $stat[0]  : device
  # $stat[1]  : inode
  # $stat[2]  : inode protection mode
  # $stat[3]  : number of links
  # $stat[4]  : user id of owner
  # $stat[5]  : group id owner
  # $stat[6]  : device type if inode device *
  # $stat[7]  : size in bytes
  # $stat[8]  : time of last access
  # $stat[9]  : time of last modification
  # $stat[10] : time of last change
  # $stat[11] : blocksize for filesystem I/O *
  # $stat[12] : number of blocks allocated
  ####################################

  # type of the file
  if (is_dir($file)) $stat[type] = 'd'; # directory
  elseif ($env[show_symlink] && is_link($file)) {
    $stat[type] = 'l'; # link
    $stat[readlink] = readlink($file);
  } elseif (is_file($file)) $stat[type] = 'f'; # file
  else $stat[type] = 'u'; # unknown

  # writable
  $stat[writable] = (is_writable($file)) ? 1 : 0;

  return $stat;
}

# fetch files list under a directory
# return an array of status of files under the directory
function FetchDir($path) {
  global $env;

  # open directory
  $files = dir($path) or Error("Error reading/opening $path");
  # dir -- directory class
  # class dir {
  #   dir(string directory);
  #   string path;
  #   resource handle;
  #   string read();
  #   void rewind();
  #   void close();
  # }


  $ret = array();
  while ($file = $files->read()) {

    # skip . and ..
    if ($file=='.' || $file=='..') continue;

    if (!$env[show_hidden_files]) {
      if (ereg("^\.", $file)) continue; # hidden file
    }

    $stat = FileStat("$path/$file");
  # echo("$path/$file<br>");
  # PrintArray($stat, 'stat');

    $stat[name] = $file;
    array_push($ret, $stat);
  }
  return $ret;
}

function TravelParents($dir) {
  global $env, $lang;

  $top = ereg_replace("\/$", "", $env[script_prefix]);  # a/ ==> a

  if ($dir == '.') $dir = "";
  $dir = ereg_replace("^\./", "", $dir);

  # exit here

  # current directory
# echo("$lang[current_dir]: ");
# echo("<a href='$top/$dir'>$lang[exit_here]</a><br>\n");
  echo("<a href='$top/$dir'>$lang[current_dir]</a>: ");

  if ($dir != '') {
    echo("<a href='$env[php_self]'>$top</a>");
    echo(" / ");
    $parents = explode("/", $dir);

    $cnt = 0;
    $path = '.';
    while (list(, $parent) = each($parents)) {
      if ($cnt) echo(" / ");
      $path .= "/$parent";
      echo("<a href='$env[php_self]?dir=$path'>$parent</a>");
      $cnt++;
    }
  } else {
    echo("<a href='$env[php_self]'>$top</a>");
  }
  echo("<br>\n");

}

function WritableMenu($dir) {
  global $env, $lang;

  # if writable
  if ($dir == "") $dir = ".";
  $stat = FileStat($dir);
  if ($stat[writable]) {
    echo("$lang[writable_dir]: ");
    $url = "$env[php_self]?mode=mkdirform&dir=$dir";
    echo("<a href='$url'>$lang[make_dir]</a>");
    if ($env[upload_on]) {
      $url = "$env[php_self]?mode=uploadform&dir=$dir";
      echo(" :: ");
      echo("<a href='$url'>$lang[file_upload]</a>");
    }
  }
}

# return a string converted from localtime
# now is an array with key (year, month, day, hour, min, sec)
function FormatLocalTime($localtime, $now, $fullformat=0) {
  global $env;

  if ($fullformat || !$env[human_time_format]) {
    $str = sprintf("%04d-%02d-%02d %02d:%02d:%02d",
       $localtime[tm_year]+1900, $localtime[tm_mon], $localtime[tm_mday],
       $localtime[tm_hour], $localtime[tm_min], $localtime[tm_sec]);
  } else {
    if ($localtime[tm_year]+1900 == $now[year] &&
        $localtime[tm_mon]+1 == $now[month] &&
        $localtime[tm_mday] == $now[day]) { # today
      $str = sprintf("%02d:%02d:%02d",
        $localtime[tm_hour], $localtime[tm_min], $localtime[tm_sec]);
    } else { # older than 1 day
      $str = sprintf("%04d-%02d-%02d",
        $localtime[tm_year]+1900, $localtime[tm_mon], $localtime[tm_mday]);
    }
  }
  return $str;
}

# read /etc/passwd and /etc/group and return arrays for them
# $ret[uid2name] is an array to convert uid to username
# $ret[gid2name] is an array to convert gid to groupname
function LoadEtcPasswd() {
  $ret = array();
  $ret[username] = array();
  $ret[groupname] = array();

  $file = file('/etc/passwd');
  while (list(,$line) = each($file)) {
    $line = trim($line);
    if (ereg("^#", $line)) continue; # skip comment lines
    $record = explode(":", $line);
  # PrintArray($record);
    $uid = $record[2];  # uid field
    $gid = $record[3];  # gid field
    $ret[uid2name][$uid] = $record[0];
  }

  $file = file('/etc/group');
  while (list(,$line) = each($file)) {
    $line = trim($line);
    if (ereg("^#", $line)) continue; # skip comment lines
    $record = explode(":", $line);
    $gid = $record[2];  # gid field
    $ret[gid2name][$gid] = $record[0];
  }

  return $ret;
}

function LD_ColorAttr(&$alt) {
  global $env, $lang;

  $str = "";
  if (!$env[field_coloring]) return $str;

  if ($alt == 0) {
    $alt = 1;
    $str = "";
  } else {
    $alt = 0;
    $str = " bgcolor='$env[color_td]'";
  }
  return $str;
}

function MakeDir() {
  global $env, $lang;
  global $form;

  if (!$env[change_on]) Error("Can't make a directory here");

  $dir = $form[dir];
  $dirname = $form[dirname];

  $oldumask = umask(0);
  $ret = mkdir("$dir/$dirname", 0755);
  umask($oldumask);

  if (!$ret) Error("mkdir failed");

  $href = "$env[php_self]?dir=$dir";
  header("Location: $href");
  exit;
}

function MakeDirForm() {
  global $env, $lang;

  if (!$env[change_on]) Error("Can't make a directory here");

  $dir = $env[dir];

  $env[page_focus] = 1;
  PageHead("$lang[make_dir]");

  TravelParents($dir);
  if ($env[change_on]) WritableMenu($dir);

  echo("<script>
function PageFocus() { document.form.dirname.focus(); }
</script>\n");
  echo("<table border='0' align='center'>
<form action='$env[php_self]' method='post' name='form'>
<tr>
<td>
<input type='hidden' name='dir' value=\"$dir\">
<input type='hidden' name='mode' value='mkdir'>
$lang[directory]:
<input type='text' name='dirname'><input
 type='submit' value='$lang[make_dir]'>
</td>
</tr>
</form>
</table>\n");
  PageTail();
  exit;
}

function Delete() {
  global $env, $lang;

  if (!$env[change_on]) Error("Can't delete here");

  $dir  = $env[dir];
  $file = $env[file];

  $target = "$dir/$file";
  if (is_dir($target)) {
    $ret = rmdir($target);
    if (!$ret) Error('rmdir error');
  } else {
    $ret = unlink("$dir/$file");
    if (!$ret) Error('unlink error');
  }

  $href = "$env[php_self]?dir=$dir";
  header("Location: $href");
  exit;
}

function UploadSubRename($post_file, $dir) {
  global $env, $lang;

  $file_name = $post_file[name];
  $file_temp = $post_file[tmp_name];

  if ($env[upload_max_size]) {
    $stat = FileStat("$file_temp");
    if ($stat[size] > $env[upload_max_size]) {
      Error("File size is too large max=$env[upload_max_size] bytes");
    }
  }

  if ($file_name) rename($file_temp, "$dir/$file_name");
}

function Upload() {
  global $env, $lang;
  global $form;

  if (!$env[change_on]) Error("Can't upload here");
  if (!$env[upload_on]) Error("Can't upload here");

  $dir  = $env[dir];


  UploadSubRename($HTTP_POST_FILES[file1], $dir);
  UploadSubRename($HTTP_POST_FILES[file2], $dir);
  UploadSubRename($HTTP_POST_FILES[file3], $dir);
  UploadSubRename($HTTP_POST_FILES[file4], $dir);
  UploadSubRename($HTTP_POST_FILES[file5], $dir);

  $href = "$env[php_self]?dir=$dir";
  header("Location: $href");
  exit;
}

function UploadForm() {
  global $env, $lang;

  if (!$env[change_on]) Error("Can't upload here");
  if (!$env[upload_on]) Error("Can't upload here");

  $dir  = $env[dir];

  $stat = FileStat("$dir");
  if (!$stat[writable]) Error("Not a writable folder");

  PageHead("$lang[file_upload]");

  TravelParents($dir);
  if ($env[change_on]) WritableMenu($dir);

  echo("<table border='0' align='center'>
<form action='$env[php_self]' enctype='multipart/form-data' method='post' name='form'>
  <tr>
  <td>$lang[file](1): <input type='file' name='file1' size='20'></td>
  </tr><tr>
  <td>$lang[file](2): <input type='file' name='file2' size='20'></td>
  </tr><tr>
  <td>$lang[file](3): <input type='file' name='file3' size='20'></td>
  </tr><tr>
  <td>$lang[file](4): <input type='file' name='file4' size='20'></td>
  </tr><tr>
  <td>$lang[file](5): <input type='file' name='file5' size='20'></td>
  </tr>
<tr>
<td align='center'>
<input type='hidden' name='dir' value=\"$dir\">
<input type='hidden' name='mode' value='upload'>
<a href='javascript:document.form.submit();'>[[$lang[upload_1]]]</a>
</td>
</tr>
</form>
</table>\n");
  PageTail();
}

function DetailInfo() {
  global $env, $lang;

  $dir  = $env[dir];
  $file = $env[file];

  if ($env[field_user] || $env[field_group]) {
    $ugid2name = LoadEtcPasswd();
  # PrintArrayR($ugid2name);
  }

  $stat = FileStat("$dir/$file");

  $now = CurrentTime();

  PageHead(sprintf($lang[detail_of], $file));

  TravelParents($dir);

  echo("<table border='0' align='center' cellspacing='1' cellpadding='2'>\n");

  $attr1 = " bgcolor='$env[color_th]' align='center'";
  $attr2 = " bgcolor='$env[color_td]'";

  echo("<tr>\n");
  echo("<td$attr1>$lang[name]</td>\n");
  echo("<td$attr2>$file</td>\n");
  echo("</tr>\n");

  global $HTTP_SERVER_VARS;
  echo("<tr>\n");
  echo("<td$attr1>URL</td>\n");
  $temp = ($dir != '.') ? "$dir/$file" : $file;
  $url = "http://$HTTP_SERVER_VARS[SERVER_NAME]$env[script_prefix]$temp";
  echo("<td$attr2><a href='$url'>$url</a></td>\n");
  echo("</tr>\n");

  $type = $lang[unknown];
  if ($stat[type] == 'f') $type = $lang[file];
  elseif ($stat[type] == 'd') $type = $lang[directory];
  echo("<tr>\n");
  echo("<td$attr1>$lang[type]</td>\n");
  echo("<td$attr2>$type</td>\n");
  echo("</tr>\n");

  echo("<tr>\n");
  echo("<td$attr1>$lang[directory]</td>\n");
  echo("<td$attr2>$dir</td>\n");
  echo("</tr>\n");

  if ($env[field_user]) {
    $username = $ugid2name[uid2name][$stat[uid]];
    echo("<tr>\n");
    echo("<td$attr1>uid</td>\n");
    echo("<td$attr2>$username ($stat[uid])</td>\n");
    echo("</tr>\n");
  }

  if ($env[field_group]) {
    $groupname = $ugid2name[gid2name][$stat[gid]];
    echo("<tr>\n");
    echo("<td$attr1>gid</td>\n");
    echo("<td$attr2>$groupname ($stat[gid])</td>\n");
    echo("</tr>\n");
  }

  list($size_format, $size_unit) = FormatByteDown($stat[7],3,1);
  $size = "$size_format $size_unit";
  list($size_format, $size_unit) = FormatByteDown($stat[7],12,1);
  $size .= " ($size_format $size_unit)";
  echo("<tr>\n");
  echo("<td$attr1>$lang[size]</td>\n");
  echo("<td$attr2>$size</td>\n");
  echo("</tr>\n");

  if ($env[field_atime]) {
    echo("<tr>\n");
    echo("<td$attr1>$lang[last_access]</td>\n");
    $atime = localtime($stat[atime], 1);
    $atime_str = FormatLocalTime($atime, $now, $fullformat=1);
    echo("<td$attr2>$atime_str</td>\n");
    echo("</tr>\n");
  }

  if ($env[field_mtime]) {
    echo("<tr>\n");
    echo("<td$attr1>$lang[last_modified]</td>\n");
    $mtime = localtime($stat[mtime], 1);
    $mtime_str = FormatLocalTime($mtime, $now, $fullformat=1);
    echo("<td$attr2>$mtime_str</td>\n");
    echo("</tr>\n");
  }

  if ($env[field_ctime]) {
    echo("<tr>\n");
    echo("<td$attr1>$lang[last_change]</td>\n");
    $ctime = localtime($stat[ctime], 1);
    $ctime_str = FormatLocalTime($ctime, $now, $fullformat=1);
    echo("<td$attr2>$ctime_str</td>\n");
    echo("</tr>\n");
  }

  if ($env[change_on]) {
    echo("<script>
function Question(msg, url) {
  if (confirm(msg)) document.location = url
  else return;
}
</script>\n");
    echo("<tr>\n");
    echo("<td$attr1>$lang[delete]</td>\n");
    echo("<td$attr2><a href=\"javascript:Question('Delete Really?','$env[php_self]?mode=delete&dir=$dir&file=$file')\">[[$lang[delete]]]</a></td>\n");
    echo("</tr>\n");
  }

  echo("</table>\n");

  PageTail();
}

# return a url string with a base url and arguments list
# e.g. baseurl?key1=val1&key2=val2[&keyN=valN]
function MakeURL($base, $args) {
  global $env, $lang;

  $url = $base;
  if (!sizeof($args)) return $url;
  
  $cnt = 0;
  while (list($key, $val) = each($args)) {
    if ($cnt) $url .= "&$key=$val";
    else $url .= "?$key=$val";
    $cnt++;
  }

  return $url;
}

# callback functions for sorting
function CompareSize($item1, $item2) {
  return ($item1[size] < $item2[size]);
}
function CompareMtime($item1, $item2) {
  return ($item1[mtime] < $item2[mtime]);
}
function CompareCtime($item1, $item2) {
  return ($item1[ctime] < $item2[ctime]);
}
function CompareAtime($item1, $item2) {
  return ($item1[atime] < $item2[atime]);
}
function CompareName($item1, $item2) {
  return strcmp($item1[name], $item2[name]);
}


# display content of a directory
function ListDir() {
  global $env, $lang;
  global $form;

  # http get variables
  $dir  = $form['dir'];
  $sort = $form['sort'];

  # if a index files exists
  if ($env['load_index_file']) {
    $index_file = "$dir/$env[index_file]";
    $index_file = ereg_replace("^\.\/", "", $index_file);
  # echo("$env[script_path]/$index_file<br>");
    if (is_file($index_file)) {
      $href = "$env[script_prefix]$index_file";
    # echo("$href<br>");
      header("Location: $href");
      exit;
    }
  }

  if ($env[field_user] || $env[field_group]) {
    $ugid2name = LoadEtcPasswd();
  # PrintArrayR($ugid2name);
  }

  if ($dir=='') $dir = '.';
  $dir2 = ($dir == '') ? '.' : $dir;

  $files = FetchDir($dir);
# echo(sizeof($files));

  # sorting
  if ($sort == 'size') usort($files, "CompareSize");
  elseif ($sort == 'mtime') usort($files, "CompareMtime");
  elseif ($sort == 'atime') usort($files, "CompareAtime");
  elseif ($sort == 'ctime') usort($files, "CompareCtime");
  elseif ($sort == 'name') usort($files, "CompareName");
  else usort($files, "CompareName");

  PageHead('');

  TravelParents($dir);
  if ($env[change_on]) WritableMenu($dir);

  $cnt_f = $cnt_d = $cnt_l = 0;
  $alt = 0;
  $attr2 = " align='center'";
  echo("<table border='0' cellpadding='2' cellspacing='0' width='100%'>\n");
  echo("<tr>\n");

  $attr = LD_ColorAttr($alt);
  $str = "<b>$lang[name]</b>";
  $url = MakeURL($env[php_self], array('sort'=>'name', 'dir'=>$dir));
  if ($url) $str = "<a href='$url'>$str</a>";
  echo("<td$attr$attr2>$str</td>\n"); #1

  if ($env[field_user]) {
    $attr = LD_ColorAttr($alt);
    $str = "<b>$lang[user]</b>";
  # $url = MakeURL($env[php_self], array('sort'=>'user', 'dir'=>$dir));
    $url = "";
    if ($url) $str = "<a href='$url'>$str</a>";
    echo("<td$attr$attr2>$str</td>\n"); #2
  }

  if ($env[field_group]) {
    $attr = LD_ColorAttr($alt);
    $str = "<b>$lang[group]</b>";
  # $url = MakeURL($env[php_self], array('sort'=>'group', 'dir'=>$dir));
    $url = "";
    if ($url) $str = "<a href='$url'>$str</a>";
    echo("<td$attr$attr2>$str</td>\n"); #3
  }

  $attr = LD_ColorAttr($alt);
  $str = "<b>$lang[size]</b>";
  $url = MakeURL($env[php_self], array('sort'=>'size', 'dir'=>$dir));
  if ($url) $str = "<a href='$url'>$str</a>";
  echo("<td$attr$attr2>$str</td>\n"); #4

  if ($env[field_mtime]) {
    $attr = LD_ColorAttr($alt);
    $str = "<b>$lang[last_modified]</b>";
    $url = MakeURL($env[php_self], array('sort'=>'mtime', 'dir'=>$dir));
    if ($url) $str = "<a href='$url'>$str</a>";
    echo("<td$attr$attr2>$str</td>\n"); #5
  }

  if ($env[field_atime]) {
    $attr = LD_ColorAttr($alt);
    $str = "<b>$lang[last_access]</b>";
    $url = MakeURL($env[php_self], array('sort'=>'atime', 'dir'=>$dir));
    if ($url) $str = "<a href='$url'>$str</a>";
    echo("<td$attr$attr2>$str</td>\n"); #6
  }

  if ($env[field_ctime]) {
    $attr = LD_ColorAttr($alt);
    $str = "<b>$lang[last_change]</b>";
    $url = MakeURL($env[php_self], array('sort'=>'ctime', 'dir'=>$dir));
    if ($url) $str = "<a href='$url'>$str</a>";
    echo("<td$attr$attr2>$str</td>\n"); #7
  }

  echo("</tr>");

  $attr1 = " nowrap";
  $attr2 = " nowrap align='center'";
  $attr3 = " nowrap align='center'";
  $tot_size = 0;
  $now = CurrentTime();
  while (list(, $stat) = each($files)) {
    $file = $stat[name];
    $type = $stat[type];

    if ($env[field_mtime]) {
      $mtime = localtime($stat[mtime], 1);
      $mtime_str = FormatLocalTime($mtime, $now);
    }
    if ($env[field_atime]) {
      $atime = localtime($stat[atime], 1);
      $atime_str = FormatLocalTime($atime, $now);
    }
    if ($env[field_ctime]) {
      $ctime = localtime($stat[ctime], 1);
      $ctime_str = FormatLocalTime($ctime, $now);
    }
    # print_r($mtime); echo("<br>");
    # print_r($atime); echo("<br>");
    # print_r($ctime); echo("<br>");

    if ($env[field_user]) $username = $ugid2name[uid2name][$stat[uid]];
    if ($env[field_group]) $groupname = $ugid2name[gid2name][$stat[gid]];

    # size
    $size = $stat[size];
    list($size_format, $size_unit) = FormatByteDown($size,3,1);
    if ($env[exact_size]) $size_str = "$size Bytes";
    else $size_str = "$size_format $size_unit";

    # <tr>
    if ($env[row_highlight]) {
      $attr = " onmouseover=this.style.background='$env[color_highlight]'"
             ." onmouseout=this.style.background=''";
    } else $attr = "";
    echo("<tr$attr>\n");

    $alt = 0;
    $attr = LD_ColorAttr($alt);
    $field_name_tmpl = "<td$attr1$attr><a"
      ." href='$env[php_self]?mode=detail&dir=$dir&file=$file'><img"
      ." src='%s' border='0' align='top'></a>"
      ." <a href='%s'>$file</a></td>\n"; #1
    $field_link_tmpl = "<td$attr1$attr><a"
      ." href='$env[php_self]?mode=detail&dir=$dir&file=$file'><img"
      ." src='%s' border='0' align='top'></a>"
      ." <a href='%s'>$file</a>(-->%s)</td>\n"; #1
    if ($env[field_user]) {
      $attr = LD_ColorAttr($alt);
      $field_user_tmpl = "<td$attr2$attr>$username</td>\n"; #2
    }
    if ($env[field_group]) {
      $attr = LD_ColorAttr($alt);
      $field_group_tmpl = "<td$attr2$attr>$groupname</td>\n"; #3
    }
    $attr = LD_ColorAttr($alt);
    $field_size_tmpl = "<td$attr2$attr>%s</td>"; #4
    if ($env[field_mtime]) {
      $attr = LD_ColorAttr($alt);
      $field_mtime_tmpl = "<td$attr3$attr>$mtime_str</td>"; #5
    }
    if ($env[field_atime]) {
      $attr = LD_ColorAttr($alt);
      $field_atime_tmpl = "<td$attr3$attr>$atime_str</td>"; #6
    }
    if ($env[field_ctime]) {
      $attr = LD_ColorAttr($alt);
      $field_ctime_tmpl = "<td$attr3$attr>$ctime_str</td>"; #7
    }

    $alt = 0;
    if ($stat[type] == 'd') { # directory
      $cnt_d++;

      $tot_size += $stat[size];

      $url = "$env[php_self]?dir=$dir/$file";
      if ($env[change_on] && $stat[writable]) {
        printf($field_name_tmpl, $env[icon_wdir], $url); #1
      } else printf($field_name_tmpl, $env[icon_dir], $url); #1
      if ($env[field_user]) printf("$field_user_tmpl"); #2
      if ($env[field_group]) printf("$field_group_tmpl"); #3
      printf("$field_size_tmpl", $size_str); #4
      if ($env[field_mtime]) printf("$field_mtime_tmpl"); #5
      if ($env[field_atime]) printf("$field_atime_tmpl"); #6
      if ($env[field_ctime]) printf("$field_ctime_tmpl"); #7

    } elseif ($stat[type] == 'f') { # file
      $cnt_f++;

      # extension
      $ext = ereg_replace(".*\.([^\.]+)$", "\\1", $file);
      $href = "$dir/$file";

      $tot_size += $stat[size];

      $url = "$dir/$file";
      if ($env[change_on] && $stat[writable]) {
        printf($field_name_tmpl, $env[icon_wfile], $url); #1
      } else printf($field_name_tmpl, $env[icon_file], $url); #1
      if ($env[field_user]) printf("$field_user_tmpl"); #2
      if ($env[field_group]) printf("$field_group_tmpl"); #3
      printf("$field_size_tmpl", $size_str); #4
      if ($env[field_mtime]) printf("$field_mtime_tmpl"); #5
      if ($env[field_atime]) printf("$field_atime_tmpl"); #6
      if ($env[field_ctime]) printf("$field_ctime_tmpl"); #7

    } elseif ($stat[type] == 'l') { # link
      $cnt_l++;

      $tot_size += $stat[size];

      $url = "$dir/$file";
      printf($field_link_tmpl, $env[icon_link], $url, $stat[readlink]); #1
      if ($env[field_user]) printf("$field_user_tmpl"); #2
      if ($env[field_group]) printf("$field_group_tmpl"); #3
      printf("$field_size_tmpl", $size_str); #4
      if ($env[field_mtime]) printf("$field_mtime_tmpl"); #5
      if ($env[field_atime]) printf("$field_atime_tmpl"); #6
      if ($env[field_ctime]) printf("$field_ctime_tmpl"); #7
    }
    echo("</tr>\n");
  }
  echo("</table>\n");
  echo("<b>$cnt_f</b> $lang[unit_files], <b>$cnt_d</b> $lang[unit_dirs]");
  if ($env[show_symlink]) {
    echo(", <b>$cnt_l</b> $lang[unit_links]");
  }

  echo(", $lang[total]: ");
  list($size_format, $size_unit) = FormatByteDown($tot_size,3,1);
  echo("<b>$size_format $size_unit</b>");
  list($size_format, $size_unit) = FormatByteDown($tot_size,12,1);
  echo(" ($size_format $size_unit)");
  echo("<br>\n");

  if ($env[disk_free_info]) {
    $diskfree = diskfreespace(".");
    list($size_format, $size_unit) = FormatByteDown($diskfree,3,1);
    echo("$lang[disk_free]: <b>$size_format $size_unit</b>");
    list($size_format, $size_unit) = FormatByteDown($diskfree,12,1);
    echo(" ($size_format $size_unit)");
  }
  PageTail();
}

function PageHead($title="") {
  global $env;

  $title_str = ($title!='') ? $title : "";
  if ($env[dir] != "") $title_str .= " - $env[dir]";

  echo("<html>
<head>
<title>$title_str</title>
<style type='text/css'>
a:link    { text-decoration:none; }
a:visited { text-decoration:none; }
a:hover   { text-decoration:underline; }
body,td,pre { font-family:Verdana,Arial,Helvetica; font-size:small; }
</style>
</head>
<body bgcolor='$env[color_bg]'");
  if ($env[page_focus]) echo(" onload=\"PageFocus();\"");
  echo(">\n");
}

function PageTail() {
  global $env, $lang;

  echo("<hr size='1'>\n");

  $date = date("Y-m-d H:i:s");
  if ($env[show_projectname]) echo("phpIndexPage ");
  echo("$date<br>\n");
  if ($env[return_home]) {
    echo("<a href='$env[return_home]'>$lang[return_home]</a>");
  }
# PrintArray($env, 'env');
  echo("</body>\n</html>\n");
}

function phpIndexPage() {
  global $env, $lang;

  # get variables from the query string of url
  global $form;
  $form = $_REQUEST;
  $mode = $form['mode'];
  $dir = $form['dir'];
  $file = $form['file'];

  if ($mode != "") $env[mode] = $mode;
  if ($dir != "")  $env[dir]  = $dir;
  if ($file != "") $env[file] = $file;

  # VERY IMPORTANT for security reason
  if (ereg("^\/", $dir))   Error('Access denied'); # $dir can't start with /
  if (ereg("\.\.", $dir))  Error('Access denied'); # $dir can't include ..
  if (ereg("^\/", $file))  Error('Access denied'); # $file can't start with /
  if (ereg("\.\.", $file)) Error('Access denied'); # $file can't include ..

  # read language file
  include("$env[inc_path]/lang/$env[lang].php");

  if ($env[mode] == 'mkdirform') {
    MakeDirForm();
  } elseif ($env[mode] == 'mkdir') {
    MakeDir();
  } elseif ($env[mode] == 'detail') {
    DetailInfo();
  } elseif ($env[mode] == 'uploadform') {
    UploadForm();
  } elseif ($env[mode] == 'upload') {
    Upload();
  } elseif ($env[mode] == 'delete') {
    Delete();
  } else {
    ListDir();
  }

  # exit here
  exit;
}

?>
