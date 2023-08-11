<?

session_start();
require_once"Database/clsuser.php";
$obj=new user();
extract($_REQUEST);
if(isset($signin)){
	$login=$obj->login();
	//header('Location:index.php?success=msg');
}

?>