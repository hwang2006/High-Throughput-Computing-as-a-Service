<?php

  $form = $_REQUEST;
  $mode = $form['mode'];
  $self = $_SERVER['PHP_SELF'];

### {{{  
function _head() {
  print<<<EOS
<html>
<head>
	   <link rel='shortcut icon'  href='./htcaas.ico'>
	  <style> .error { font-size:12px; color:#FF0000; }  
    </style>
<title> JSDL Generator </title>
</head>
<body>
	  <form name='form' action='$self' method='get'>
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
Values: <input type='text' name='list{$no}' size='80' value="1,2,3" >
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
  $tb="";
  $tab ="\t";

  if ($item['vartype'] == '1') { // start/stop/step
    $start = $item['start'];
    $stop  = $item['stop'];
    $step  = $item['step'];
if($no>1  ){
 for ($m = 1; $m <= $no; $m++) {
     $tb.="    ";
  }	 
}
    $jsdl=<<<EOS
$indent$tb<ns3:Sweep>
$indent$tb$tab<ns3:Assignment>
$indent$tb$tab$tab<ns3:DocumentNode>
$indent$tb$tab$tab$tab<ns3:Match>$varname</ns3:Match>
$indent$tb$tab$tab</ns3:DocumentNode>
$indent$tb$tab$tab<ns3:LoopInteger start="$start" end="$stop" step="$step" />
$indent$tb$tab</ns3:Assignment>

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
$indent$tab<ns3:Assignment>
$indent$tab$tab<ns3:DocumentNode>
$indent$tab$tab$tab<ns3:Match>$varname</ns3:Match>
$indent$tab$tab</ns3:DocumentNode>
$indent$tab$tab<ns3:Values>
$tab$tab$tab$Values
$indent$tab$tab</ns3:Values>
$indent$tab</ns3:Assignment>

EOS;

  } else if ($item['vartype'] == '3') { // files in a directory

    $path = $item['path'];
    $jsdl=<<<EOS
$indent<ns3:Sweep>
$indent$tab<ns3:Assignment>
$indent$tab$tab<ns3:DocumentNode>
$indent$tab$tab$tab<ns3:Match>$varname</ns3:Match>
$indent$tab$tab</ns3:DocumentNode>
$indent$tab$tab<ns3:Directory filenameonly="true">
$indent$tab$tab$tab<ns3:Name>$path</ns3:Name>
$indent$tab$tab</ns3:Directory>
$indent$tab</ns3:Assignment>

EOS;
  }


  return $jsdl;
}

function make_sweep(&$info) {
 // dbg($info);

  $jsdl = '';
   
  $numloop = $info['numloop'];
  $ap_name= $info['app_name'];
  $ex_name= $info['exe_name'];
  $numin= $info['numin'];
  $numout= $info['numout'];

  $jsdl.= "\t<JobDescription>\n";
  $jsdl.= "\t\t<Application>\n";
   $jsdl.= "\t\t\t<ApplicationName>"; 
    $jsdl.= $ap_name; 
 $jsdl.="</ApplicationName>\n"; 
$jsdl.="\t\t\t<ns2:POSIXApplication>\n"; 
$jsdl.="\t\t\t\t<ns2:Executable>"; 
$jsdl.=$ex_name;
$jsdl.="</ns2:Executable>\n";
  for ($n = 1; $n <= $numloop; $n++) {
    $item = $info["loop_{$n}"];
	$nm=$item['varname'];
	$jsdl.="\t\t\t\t<ns2:Argument>"; 
	$jsdl.=$nm;
	$jsdl.="</ns2:Argument>\n";
  }
 $jsdl.="\t\t\t</ns2:POSIXApplication>\n"; 
  $jsdl.= "\t\t</Application>\n"; 

   for ($no = 1; $no <= $numin; $no++) {
    $jsdl.= "\t\t<DataStaging>\n"; 
    $jsdl.= "\t\t\t<FileName>";
	$jsdl.= $info["in_{$no}"]['inname'];
	$jsdl.= "</FileName>\n";
    $jsdl.= "\t\t\t<Source>\n\t\t\t\t<URI>";
    $jsdl.= $info["in_{$no}"]['inloc'];
	$jsdl.="/";
	$jsdl.= $info["in_{$no}"]['inname'];
	$jsdl.="</URI>\n \t\t\t</Source>\n";
	$jsdl.= "\t\t</DataStaging>\n"; 
  }

     for ($no = 1; $no <= $numout; $no++) {
    $jsdl.= "\t\t<DataStaging>\n"; 
    $jsdl.= "\t\t\t<FileName>";
	$jsdl.= $info["out_{$no}"]['outname'];
	$jsdl.= "</FileName>\n";
    $jsdl.= "\t\t\t<Target>\n\t\t\t\t<URI>";
    $jsdl.= $info["out_{$no}"]['outloc'];
     $jsdl.= "/";
	$jsdl.= $info["out_{$no}"]['outname'];
	$jsdl.="</URI>\n \t\t\t</Target>\n";
	$jsdl.= "\t\t</DataStaging>\n"; 
  }
 $jsdl.=  "\t</JobDescription>\n";
 
  for ($no = 1; $no <= $numloop; $no++) {
    $item = $info["loop_{$no}"];
    $jsdl .= make_sweep_sub($item, $no);
  }
  for ($no = 1; $no <= $numloop; $no++) {
    $jsdl .= "    </ns3:Sweep>\n";
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
  dbg($form);

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
   
  function _process_in(&$info, $no){
     global $form;

	  $info["in_$no"]=array();
      $inname = $form["inname$no"];
	  $inloc= $form["inloc$no"];
      $info["in_$no"]['inname'] = $inname;      
      $info["in_$no"]['inloc'] = $inloc;      
 
   }
  
    function _process_out(&$info, $no){
     global $form;

	  $info["out_$no"]=array();
      $outname = $form["outname$no"];
	  $outloc= $form["outloc$no"];
      $info["out_$no"]['outname'] = $outname;      
      $info["out_$no"]['outloc'] = $outloc;      
 
   }
   $numloop = $form['numloop'];
   $numin = $form['num_input'];
   $numout = $form['num_output'];
   $ap_name = $form['app_name'];
   $ex_name=$form['exe_name'];

  $info = array();
  $info['numloop'] = $numloop;
  $info['numin'] = $numin;
   $info['numout'] = $numout;
 $info['app_name'] = $ap_name;
  $info['exe_name'] =$ex_name;

   for ($i = 1; $i <= $numin; $i++) {
    _process_in($info, $i);
  }

     for ($i = 1; $i <= $numout; $i++) {
    _process_out($info, $i);
  }

  for ($i = 1; $i <= $numloop; $i++) {
    _process($info, $i);
  }
 // dbg($info);
  $temp ="<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"yes\"";  
  $temp .="?>\n";
  $temp .="  <JobDefinition xmlns=\"http://schemas.ggf.org/jsdl/2005/11/jsdl\" xmlns:ns2=\"http://schemas.ggf.org/jsdl/2005/11/jsdl-posix\" xmlns:ns3=\"http://schemas.ogf.org/jsdl/2009/03/sweep\"> ";

  $jsdl = make_sweep($info);
  $tail = "</JobDefinition>";

  print<<<EOS
<form name='it'>
<input onclick="copyit('it.select1')" type='button'  value='Select All' name='cpy'  style="font-family:Calibri; font-size:10pt; height:20; width:100; background:#EFEFEF; border:1 solid #808080; cursor:hand"> 
 <input onclick="javascript:self.location='http://htcaas.kisti.re.kr/jsdl/';" type='button'  value='Home' name='home'  style="font-family:Calibri; font-size:10pt; height:20; width:80; background:#EFEFEF; border:1 solid #808080; cursor:hand"><br>
<textarea name='select1' rows='30' cols='120' style='font-family:courier new'>
$temp
  $jsdl
  $tail
</textarea>
</form>

<font size="2" face="돋음" color="#000000">
&#169; 2013 KISTI,  <a href="http://htcaas.kisti.re.kr"><font face="calibri" size="2" color="#000000">HTCaaS 
</font> </a>. All rigts reserved. 


<script>
function copyit(theField) {
var tempval=eval("document."+theField) ;
    tempval.focus();
    tempval.select();
  //   therange=tempval.createTextRange(); 
    //therange.execCommand("Copy");
    //alert ("Copied. Use Ctrl+V to paste it.");
}
</script>
EOS;

  exit;
}
### }}}

  _head();


  print<<<EOS

<center><h2> JSDL </h2>
<font size="2"> (It is <b>NOT</b> supported by <img  src="./images/ie_icon.png"> ) </font></br>                                          
<span class="error">* required field.</span> </center> 
<table cellspacing="2" cellpadding="5" style="border:2 solid #808080" align="center">


<th colspan =2 > <h3>Step 1</h3> </th>

<tr>
<td><b> Application name : </b></td>
<td>
<input type="text" name="app_name" value="general" size="20" maxlength="20">  <span class="error">*Do not correct   </span>
</td>
</tr>

<tr>
<td><b> Executable name: </b></td>
<td>
<input type="text" name="exe_name" value="example.sh" size="20" maxlength="30" style="color:#0099ff"> <span class="error">* </span>
</td></tr>
EOS;

  $opts = "";
  for ($i = 0; $i <= 10; $i++) {
    $opts .= "<option value='$i'>$i</option>";
  }

  print<<<EOS
<tr>
<td><b> Num of Input files: </b></td>
<td>
<select name="num_input" style="font-size:9pt" onchange="showItems(num_input.value, 1 )" >$opts</select><span class="error">* </span>
</td>
</tr>
EOS;

	// output
	$opts = "";
	for ($i = 0; $i <=10; $i++) {
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
<input type='radio' name='numloop' value='0' onclick='clk_numloop()'>0
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
<input onclick="javascript:history.go(0);" type='button'  value='Refresh' name='refresh'  style="font-family:Calibri; font-size:10pt; height:20; width:80; background:#EFEFEF; border:1 solid #808080; cursor:hand"><br>
<font size="2" face="돋음" color="#000000">
&#169; 2013 KISTI,  <a href="http://htcaas.kisti.re.kr"><font face="calibri" size="2" color="#000000">HTCaaS 
</font> </a>. All rigts reserved. 
</center>
EOS;
  
  print<<<EOS

<script src="ajax_xmlhttp.js"></script>
<script>

var form = document.form;

function showItems(n,m)
{
 var item_disp = ""; 

 if (m==1) { 
			 for(var i=0; i<n; i++)
			 {  if(i==0){
			 			 item_disp += 'name : <input type="text" size="12" name="inname' + (i+1) + '"  value="'+form.exe_name.value+'" style="height:20; border:1 solid #000000">&nbsp;&nbsp;';
			 item_disp += 'location : <input type="text" size="30" name="inloc' + (i+1) + '" value="/home/userID" style="height:20; border:1 solid #000000; color:gray"><br>';
			  }else{
			 item_disp += 'name : <input type="text" size="12" name="inname' + (i+1) + '" style="height:20; border:1 solid #000000">&nbsp;&nbsp;';
			 item_disp += 'location : <input type="text" size="30" name="inloc' + (i+1) + '" value="/home/userID" style="height:20; border:1 solid #000000; color:gray"><br>';
			  }
			 }
} else if(m==2) {
			 for(var i=0; i<n; i++)
		 {  
		 item_disp += 'name : <input type="text" size="12" name="outname' + (i+1) + '" style="height:20; border:1 solid #000000">&nbsp;&nbsp;';
		 item_disp += 'location : <input type="text" size="30" name="outloc' + (i+1) + '" value="/home/userID" style="height:20; border:1 solid #000000;color:gray"><br>';
		 }
}
 no_options=n; 
 
 if (m==1) {  this.document.all.items.innerHTML = item_disp;
 } else if (m==2) {  
     this.document.all.item2.innerHTML = item_disp;
 }

 }


function numloop_cb() {
		  if (xmlHttp.readyState == 4) {
			var text = xmlHttp.responseText;
			var div = document.getElementById("LoopInfoDiv");
			div.innerHTML = text;
		  }
}

function clk_numloop() {
		 // var a = 1;
		  var a = 0;
		  if (form.numloop[0].checked) a = form.numloop[0].value;
		  if (form.numloop[1].checked) a = form.numloop[1].value;
		  if (form.numloop[2].checked) a = form.numloop[2].value; 
		   if (form.numloop[3].checked) a = form.numloop[3].value;

		  var url = "$self?mode=numloop&count="+a;
		  console.log(url);
		  xmlHttp.open("GET", url, true);
		  xmlHttp.onreadystatechange = numloop_cb;
		  xmlHttp.send(null);
}

var g_div = '';
function clk_lvtype(radio_name, div_id, no) {
 
				//var rdo = eval("form."+radio_name);
				// alert(form.lv1type[0].checked);
				var aa = "form."+radio_name;
				 var rdo = eval(aa);

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
