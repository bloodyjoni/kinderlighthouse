<?php
session_start();

//---------------------	GET AND SET VARS POST/GET -----------------------
$var_qty = count($_REQUEST);
$var_keys = array_keys($_REQUEST); 
$var_values = array_values($_REQUEST);

for($i=0;$i<$var_qty;$i++){ 
	if (substr($var_keys[$i],0,4) == "amp;"){
		$var = substr($var_keys[$i],-intval(strlen($var_keys[$i])-4));
	}else{
		$var = $var_keys[$i];
	}
	$$var=$var_values[$i];
}
//-----------------------------------------------------------------------

?>