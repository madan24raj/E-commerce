<?
error_reporting(1);
session_start();
require_once"Database/clsuser.php";
$obj=new user();
extract($_REQUEST);

if($action=="stocksearch"){
	$sql=$obj->getstock($size,$color,$code);
	
	while($res=mysql_fetch_assoc($sql)){
	 //echo $res['branch_name']." - ".$res['ifsc'];
	$json=$res['size'];			
		}
	echo $json;
}
if(isset($checkemail)){
	$sql=$obj->checkemail($email);
	echo mysql_num_rows($sql);
}
if(isset($checkmob)){
	$sql=$obj->checkmob($mobile);
	echo mysql_num_rows($sql);
}
if(isset($register)){
	$chk=mysql_num_rows(mysql_query("SELECT * FROM users where Email='$email' or Mobile='$mobile'"));
		if(empty($chk)){
			
			mysql_query("insert into users (`Name`, `Gender`, `Email`, `Password`, `Mobile`, `Address`,`Area`, `City`,`State`,`Pincode`) values 
				('$name','$gender','$email','$pass','$mobile','$address','$area','$city','$state','$pincode')");
				
}
echo $chk;
}
if(isset($login)){
	$usrnm=mysql_real_escape_string($email);
	$pas=mysql_real_escape_string($pass);
	$sql=mysql_fetch_assoc(mysql_query("select Id,Name,Email from users where Email='$usrnm' and Password='$pas'"));
		$_SESSION['id']=$sql['Id'];
		$_SESSION['name']=$sql['Name'];
		$_SESSION['email']=$sql['Email'];
       echo $_SESSION['id'];

	}

	if(isset($order)){
	$ord.='KM';
$yr=date('y');
$ord.=$yr;
$no=rand(0000,9999);
$ord.=$no;
$sta=$obj->getstates($state);
$states=$sta['States'];
$adhar=$address.','.$area.','.$city.','.$states.'-'.$pincode;
$max=count($_SESSION['cart']);
			for($i=0;$i<$max;$i++){
					$pcodes[$i]=$_SESSION['cart'][$i]['prodcode'];
					$sizes[$i]=$_SESSION['cart'][$i]['size'];
					$colors[$i]=$_SESSION['cart'][$i]['color'];
					$quans[$i]=$_SESSION['cart'][$i]['quan'];
				}
$pcode=implode(",",$pcodes);				
$size=implode(",",$sizes);				
$color=implode(",",$colors);				
$quan=implode(",",$quans);				
$sql="insert into orders(`ord_id`,`prod_codes`,`size`,`items`,`color`,`cust_name`,`shipping_address`,`mobile`,`total_pay`,`userid`) values ('$ord','$pcode','$size','$quan','$color','$dname','$adhar','$mobile2','$ordprice','$userid')";
mysql_query($sql);
 
 echo $ord;
	}
	if($action=="checkcoupon"){
	$sql=$obj->getcoupon($ccode);
	$count=mysql_num_rows($sql);
	if($count=0){
		echo "0";
	}
	else{
		$disc=mysql_fetch_assoc($sql);
		echo $disc['percent'];
	}
}
if(isset($changepass)){
	$sql=mysql_query("update users set `Password`='$newpass' where Id='".$_SESSION['id']."'");
	echo $sql;
}
?>
