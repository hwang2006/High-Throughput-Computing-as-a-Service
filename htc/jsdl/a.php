<?php

  $form = $_REQUEST;
  $mode = $form['mode'];
  $self = $_SERVER['PHP_SELF'];

### {{{  
function _head() {
  print<<<EOS
<html>
<head>
<title> JSDL generator </title>
</head>
<body>
EOS;
}
function _tail() {
  print<<<EOS
</body>
</html>
EOS;
}

function dbg($msg) {
       if (is_string($msg)) print($msg);
  else if (is_array($msg)) { print("<pre>"); print_r($msg); print("</pre>"); }
  else print_r($msg);
}

function _loop_info($i) {

  $var_name = "lvname{$i}";
  $radio_name = "lv{$i}type";
  $div_id = "LoopVarInfoDiv{$i}";
  $rid1 = "lvt{$i}_1";
  $rid2 = "lvt{$i}_2";
  $rid3 = "lvt{$i}_3";

  print<<<EOS
<hr>
Loop Variable #$i<br>
Name: <input type='text' name='$var_name' size='10' value="VAR{$i}"><br>
Type: 
<input type='radio' name='$radio_name' value='1'
 onclick="clk_lvtype('$radio_name', '$div_id', '$i')" id='$rid1'><label for='$rid1'>start/stop/step</label>

<input type='radio' name='$radio_name' value='2'
 onclick="clk_lvtype('$radio_name', '$div_id', '$i')" id='$rid2'><label for='$rid2'>list of values</label>

<input type='radio' name='$radio_name' value='3'
 onclick="clk_lvtype('$radio_name', '$div_id', '$i')" id='$rid3'><label for='$rid3'>files in a directory</label>

<div id='$div_id'></div>
EOS;
}

function loop_form($type, $no) {
  if ($type == 'sss') {
    print<<<EOS
Start: <input type='text' name='start{$no}' size='10' value='1'>
Stop: <input type='text' name='stop{$no}' size='10' value='10'>
Step: <input type='text' name='step{$no}' size='10' value='1'>
EOS;
  } else if ($type == 'lov') {
    print<<<EOS
Values: <input type='text' name='list{$no}' size='80' value="1,2,3,5,7,11,13,17">
EOS;
  } else if ($type == 'fid') {
    print<<<EOS
Dir Path: <input type='text' name='path{$no}' size='80' value="/path/to/a/directory">
EOS;
  }
}

function make_sweep_sub($item, $no) {
  //dbg($item);

  $indent = str_repeat("   ", $no);

  $varname = $item['varname'];

  if ($item['vartype'] == '1') { // start/stop/step
    $start = $item['start'];
    $stop  = $item['stop'];
    $step  = $item['step'];
    $jsdl=<<<EOS
$indent<ns3:Sweep>
$indent<ns3:Assignment>
$indent<ns3:DocumentNode>
$indent<ns3:Match>$varname</ns3:Match>
$indent</ns3:DocumentNode>
$indent<ns3:LoopInteger start="$start" end="$stop" step="$step" />
$indent</ns3:Assignment>

EOS;

  } else if ($item['vartype'] == '2') { // list of values

    $vlist = $item['list'];
    $vals = preg_split("/,/", $vlist);
    $Values = "";
    foreach ($vals as $v) {
      $Values .=<<<EOS
<ns3:Value xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xs="http://www.w3.org/2001/XMLSchema" xsi:type="xs:string">$v</ns3:Value>\n
EOS;
    }
    $jsdl=<<<EOS
$indent<ns3:Sweep>
$indent<ns3:Assignment>
$indent<ns3:DocumentNode>
$indent<ns3:Match>$varname</ns3:Match>
$indent</ns3:DocumentNode>
$indent<ns3:Values>
$Values
$indent</ns3:Values>
$indent</ns3:Assignment>

EOS;

  } else if ($item['vartype'] == '3') { // files in a directory

    $path = $item['path'];
    $jsdl=<<<EOS
$indent<ns3:Sweep>
$indent<ns3:Assignment>
$indent<ns3:DocumentNode>
$indent<ns3:Match>$varname</ns3:Match>
$indent</ns3:DocumentNode>
$indent<ns3:Directory filenameonly="true">
$indent<ns3:Name>$path</ns3:Name>
$indent</ns3:Directory>
$indent</ns3:Assignment>

EOS;
  }


  return $jsdl;
}

function make_sweep(&$info) {
  dbg($info);

  $jsdl = '';
  $numloop = $info['numloop'];
  for ($no = 1; $no <= $numloop; $no++) {
    $item = $info["loop_{$no}"];
    $jsdl .= make_sweep_sub($item, $no);
  }
  for ($no = 1; $no <= $numloop; $no++) {
    $jsdl .= " </ns3:Sweep>\n";
  }

  return $jsdl;
}

### }}}

### {{{
if ($mode == 'numloop') {
  //dbg($form);
  $count = $form['count'];
  for ($i = 1; $i <= $count; $i++) {
    _loop_info($i);
  }
  exit;
}
if ($mode == 'loopform') {
  $type = $form['type'];
  $no = $form['no'];
  loop_form($type, $no);
  exit;
}

if ($mode == 'step2') {
  //dbg($form);

  function  _process(&$info, $no) {
    global $form;

    $info["loop_$no"] = array();

    $varname = $form["lvname$no"];
    $info["loop_$no"]['varname'] = $varname;

    $vartype = $form["lv{$no}type"];
    $info["loop_$no"]['vartype'] = $vartype;

    if ($vartype == '1') {
      $info["loop_$no"]['start'] = $form["start{$no}"];
      $info["loop_$no"]['stop'] = $form["stop{$no}"];
      $info["loop_$no"]['step'] = $form["step{$no}"];
      
    } else if ($vartype == '2') {
      $info["loop_$no"]['list'] = $form["list{$no}"];

    } else if ($vartype == '3') {
      $info["loop_$no"]['path'] = $form["path{$no}"];
    }

  }

  $numloop = $form['numloop'];

  $info = array();
  $info['numloop'] = $numloop;

  for ($i = 1; $i <= $numloop; $i++) {
    _process($info, $i);
  }
  //dbg($info);

  $jsdl = make_sweep($info);
  print<<<EOS
<textarea rows='20' cols='80'>
$jsdl
</textarea>
EOS;

  exit;
}
### }}}

  _head();

  print<<<EOS
<form name='form' action='$self' method='get'>
Number of Loops : 
<input type='radio' name='numloop' value='1' onclick='clk_numloop()'>1
<input type='radio' name='numloop' value='2' onclick='clk_numloop()'>2
<input type='radio' name='numloop' value='3' onclick='clk_numloop()'>3
<input type='hidden' name='mode' value='step2'>
<input type='button' value='OK' onclick='sf_1()'>
<div id='LoopInfoDiv'></div>
</form>

<script src="ajax_xmlhttp.js"></script>
<script>

var form = document.form;

function numloop_cb() {
  if (xmlHttp.readyState == 4) {
    var text = xmlHttp.responseText;
    var div = document.getElementById("LoopInfoDiv");
    div.innerHTML = text;
  }
}

function clk_numloop() {
  var a = 1;
  if (form.numloop[0].checked) a = form.numloop[0].value;
  if (form.numloop[1].checked) a = form.numloop[1].value;
  if (form.numloop[2].checked) a = form.numloop[2].value;

  var url = "$self?mode=numloop&count="+a;
  console.log(url);
  xmlHttp.open("GET", url, true);
  xmlHttp.onreadystatechange = numloop_cb;
  xmlHttp.send(null);
}

var g_div = '';
function clk_lvtype(radio_name, div_id, no) {
  var rdo = eval("form."+radio_name);
  var type = '';
  g_div = div_id;

  if (rdo[0].checked) {
    type = 'sss';
  } else if (rdo[1].checked) {
    type = 'lov';
  } else if (rdo[2].checked) {
    type = 'fid';
  }

  var url = "$self?mode=loopform&type="+type+"&no="+no;
  console.log(url);
  xmlHttp.open("GET", url, true);
  xmlHttp.onreadystatechange = lvtype_cb;
  xmlHttp.send(null);
}

function lvtype_cb() {
  if (xmlHttp.readyState == 4) {
    var text = xmlHttp.responseText;
    var div = document.getElementById(g_div);
    div.innerHTML = text;
  }
}


function sf_1() {
  form.submit();
}
</script>
EOS;

  _tail();
  exit;

?>
