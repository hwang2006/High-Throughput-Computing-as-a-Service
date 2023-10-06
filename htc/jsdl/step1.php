<?php


  print<<<EOS
<html>
<head>
<title>...........</title>
</head>
<body>

<center><h2> JSDL </h2></br></center>

<table cellspacing="5" cellpadding="5" style="border:2 solid #808080" align="center">

<form name="form" method="post" action="step2.php">
<th colspan =2 > <h2>Step 1</h2></th>'

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
<select name="num_input" style="font-size:9pt">$opts</select>
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
<select name="num_output" style="font-size:9pt" >$opts</select>
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
<b> Num of arguments: </b>
</td>
<td>
<select name="num_args" style="font-size:9pt" >$opts</select>
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


<script>
function submitForm() {
  document.form.submit();
}
</script>

  
</body>
</html>
EOS;

?>
