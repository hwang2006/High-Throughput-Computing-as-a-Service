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

<center><h2> JSDL </h2></br></center>
<table cellspacing="5" cellpadding="5" style="border:2 solid #808080" align="center">

<form name='form' action='$self' method='get'>
<th colspan =2 > <h3>Step 1</h3></th>

<tr>
<td><b> Application name : </b></td>
<td>
<input type="text" name="app_name" value="general" size="20" maxlength="20">
</td>
</tr>

<tr>
<td><b> Executable name: </b></td>
<td>
<input type="text" name="exe_name" value="example.sh" size="30" maxlength="30">
</td></tr>
EOS;

  $opts = "";
  for ($i = 0; $i <= 3; $i++) {
    $opts .= "<option value='$i'>$i</option>";
  }

  print<<<EOS
<tr>
<td><b> Num of Input files: </b></td>
<td>
<select name="num_input" style="font-size:9pt" onchange="showItems(num_input.value, 1 )">$opts</select>
</td>
</tr>
EOS;

	// output
	$opts = "";
	for ($i = 0; $i <= 30; $i++) {
		$opts .= "<option value='$i'>$i</option>";
	}


print<<<EOS

<tr><td>
<b> Num of output files: </b>
</td>
<td>
<select name="num_output" style="font-size:9pt" onchange="showItems(num_output.value , 2 )" >$opts</select>
</td>
</tr>
EOS;

	//arguments
	$opts = "";
	for ($i = 0; $i <= 30; $i++) {
		$opts .= "<option value='$i'>$i</option>";
	}
  
print<<<EOS
<tr>
<td>
<b> Num of Variables: </b>
</td>
<td>
<input type='radio' name='numloop' value='1' onclick='clk_numloop()'>1
<input type='radio' name='numloop' value='2' onclick='clk_numloop()'>2
<input type='radio' name='numloop' value='3' onclick='clk_numloop()'>3
<input type='hidden' name='mode' value='step2'>

</td>  
</tr>
</form>
</table>
</br>


<table cellspacing="5" cellpadding="5" style="border:2 solid #808080" align="center" style="width:550px">
<th > <h3>Step 2</h3></th>
<tr><td>
<center><h3>Input </h3></center>
<center><div id="items">
</div><br></center>
<center><h3>Output </h3></center>

<center><div id="item2">

</div><br></center>


<center><h3>  Variables </h3></center>
<center><div id="item3">
<div id='LoopInfoDiv'></div>
</div>  <br></center>

</td></tr>
<tr>
<td>
<center><div id="item4">
</div>  <br></center>
</td>
</tr>

<tr>
<td>
<center>
<input type='button' value='OK' onclick='sf_1()'>

    </center>
</td>
</tr>
</table>
</br>
<center>
<font size="2" face="돋음" color="#000000">
&#169; 2013 <a href="http://htcaas.kisti.re.kr"><font face="calibri" size="2" color="#000000">KISTI, HTCaaS 
</font> </a>. All rigts reserved. 
</center>
EOS;
  
  print<<<EOS

<script src="ajax_xmlhttp.js"></script>
<script>

function showItems(n,m)
{
 var item_disp = "";
 for(var i=0; i<n; i++)
 {
 item_disp += 'name : <input type="text" size="12" name="option' + (i+1) + '" style="height:20; border:1 solid #000000">&nbsp;&nbsp;';
 item_disp += 'location : <input type="text" size="30" name="linkto' + (i+1) + '" style="height:20; border:1 solid #000000"><br>';
 }
 no_options=n; 
 
 if (m==1) {  this.document.all.items.innerHTML = item_disp;
 } else if (m==2) {  
     this.document.all.item2.innerHTML = item_disp;
 }

 }

function showItems2(n)
{
 var item_disp = "";
 for(var i=0; i<n; i++)
 {
  item_disp += 'Type of args : <input type="text" size="12" name="option' + (i+1) + '" style="height:20; border:1 solid #000000" value="ARG'+(i+1)+'">&nbsp;&nbsp;';
 item_disp += ' <input type = "Radio" name="var_type' + (i+1) + '"  value="type1" checked="checked" onclick="show(this.value)" > Values</td> ';
 item_disp +=  '<input type = "Radio" name="var_type' + (i+1) + '" value="type2"  onclick="show(this.value)"> Loop </td>';
 item_disp += '<input type = "Radio" name="var_type' + (i+1) + '" value="type3"  onclick="show(this.value)"> Dir_Loop </td>';
 item_disp += '</br>';
 }
 no_options=n; 

 this.document.all.item3.innerHTML = item_disp; 

 }


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
