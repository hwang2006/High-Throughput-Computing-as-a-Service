<html>
<?php 
 
 
	session_cache_limiter('');
    session_start();
      
	$app_name = $_POST['app_name'];
	$exe_name = $_POST['exe_name'];
	$num_input = $_POST['num_input'];
	$num_output = $_POST['num_output'];
	$num_args = $_POST['num_args'];

	 echo "<table cellspacing='5' cellpadding='5' style='border:2 solid #808080' align='center'>";
	 echo "<th colspan =2 > <h2>Step 1</h2></th>";
	 echo "<tr><td><b> Application name : </b></td>";
     echo "<td>";    
     echo $app_name; 
	 echo"</td></tr>";

	 echo "<tr><td><b> Executable name: </b></td>";
	 echo "<td>";   
	 echo $exe_name;
	 echo "</td></tr>";
   
   	 echo "<tr><td><b> Num of Input File: </b></td>";
     echo "<td>";   
	 echo $num_input;
	 echo "</td></tr>";
    
   	 echo "<tr><td><b> Num of Output File: </b></td>";
     echo "<td>";   
	 echo $num_output;
	 echo "</td></tr>";

   	 echo "<tr><td><b> Num of Arguments: </b></td>";
     echo "<td>";   
	 echo $num_args;
	 echo "</td></tr>";

     echo "</table>";

     echo "<br>";
 

	
	 echo "<table cellspacing='5' cellpadding='5' style='border:2 solid #808080' align='center'>";
	 echo "<th colspan =3> <h2>Step 2</h2><br><b>[Arguments Type]</b></th> "; 

	//배열 선언
	 $arg_arr= array();

     for ($i =0 ; $i <  $num_args;  $i ++) { 
	 echo "<form name ='jsdl_step2'>";	
			echo "<tr cellspacing='2' cellpadding='2'style='border:1.5 solid #666666' align='center'><td> "; 
			echo $i+1;
			echo "</td>";
			echo "<td><input type = 'Radio' name='arg'  value='independent' checked='checked'>Independent</td>"  ;
			echo "<td ><input type = 'Radio' name='arg' value='loop'>Loop</td>"  ;
			
      echo "</form>";

			if($_REQUEST[arg]=='independent'){ 
				echo "<td>INDEPENDENT</td>";
			
			} else if ($_REQUEST[arg]=='loop') {
			  echo "<td>LOOP</td>";
			} else {  
			echo "<td>  </td>";
			}
			echo "</tr>"; 
      }

	 echo "</table>";
   
	  
	  ?>  
</html>


