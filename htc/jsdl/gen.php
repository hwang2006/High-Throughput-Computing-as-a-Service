<?php


print<<<EOS
	<html>
	<head>
		<title> JSDL generator </title>
	</head>	
	<body>


<center><h2> JSDL </h2></br></center>
<table cellspacing="5" cellpadding="5" style="border:2 solid #808080" align="center">

<form name="jsdl_step1" >
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
  for ($i = 0; $i <= 30; $i++) {
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
<tr><td>
<b> Num of Variables: </b>
</td>
<td>
<select name="num_args" style="font-size:9pt" onchange="showItems2(num_args.value )" >$opts</select>
</td>   
</tr>
EOS;

  print<<<EOS
<tr>
<td colspan=2>
<center>
<input type="button" name="next1" value="Next>>"
 onclick="submitForm()" 
  style="font-family:Calibri; font-size:10pt; height:20; width:32%; background:#EFEFEF; border:1 solid #808080; cursor:hand">
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
<input type="button" name="next2" value="Next>>"
 onclick="submitForm()" 
  style="font-family:Calibri; font-size:10pt; height:20; width:100px; background:#EFEFEF; border:1 solid #808080; cursor:hand">
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


<script>
function submitForm() {
  document.form.submit();
}

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
</script>

<script>
 function show(n)
 {
	// alert("your type is "+ n); 
    var disp ="" ;

     if ( n == "type1") {
	 disp += '<br>values!!!'; 
	 } else if (n=="type2"){
		 disp += '<br>loop!!!';}
	else {
	   disp += '<br>dir_loop!!!';
	}

	this.document.all.item4.innerHTML = disp;

 }
/*
function showItem3(i ,c)
{
	var item_disp = "";
    
   if (c == 1 ) {
	item_disp += '<br>values!!!';
	this.document.all.arg+$i.innerHTML = item_disp;
   } else if (c==2 ){
	  	item_disp += '<br>Loop!!!';
	this.document.all.arg+$i.innerHTML = item_disp;

   } else {
 	  	item_disp += '<br>Dir_Loop!!!';
	this.document.all.arg+$i.innerHTML = item_disp;
   }
  
}
*/

</script>

  
</body>
</html>
EOS;

?>
