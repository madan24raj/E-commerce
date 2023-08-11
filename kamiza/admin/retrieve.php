<?php
	$prtcode = $_REQUEST['prtcode'];
	
	$conn = mysql_connect("localhost", "user_kamiza", "Collections123");
	mysql_select_db("kamiza_collections") or die();
	
	$prtcode = (string)mysql_real_escape_string($prtcode);
	
	$sql = "SELECT Name,Cat_id,Subcat_id,Subsubcat_id,Description,Price FROM product WHERE Prod_code = '$prtcode'";
	$data = mysql_query($sql);
	if(!$data) {
		die(mysql_error());
	}
	$row = mysql_fetch_row($data);
	$name = $row[0];
	$cat = $row[1];
	$sub = $row[2];
	$subsub=$row[3];
	$desc=$row[4];
	$price=$row[5];
	header('Content-type: application/json');
	$array = array('name'=>$name, 'cat'=>$cat, 'sub'=>$sub,'subsub'=>$subsub,'desc'=>$desc,'price'=>$price);
	echo json_encode($array);
?>
