<?
extract($_REQUEST);
session_start();
require_once"../Database/clsuser.php";
$obj=new user();
?>

<html>
<head>
<title>Admin</title>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <link rel="stylesheet" href="../css/style_own.css">
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>
<?
if(isset($login)){
   
	$obj->admin($username,$password);
}
if(isset($log)){
	echo "<script>
		$(function(){
		$('#err').html('Invalid Username and Password');
	});</script>";
	

}
?>
<body>
<div class="p-2 w-100" style="background-color:#112655;">
<div class="row wraper">
<div class="col-xl-6 pl-5">
<img class="img-fluid" src="../images/Kamiza-Collection-Logo.png" width="auto" height="auto" />
</div>
</div>
</div>
<form method="post">
<div class="width_100 pt-5 text-center">
<span id="err" style="color:red;"></span>
</div>
<div class="width_100 text-center">
<input class="text_box" type="text" name="username" placeholder="Username" />
</div> 
<div class="width_100 pt-2 text-center">
<input type="password" class="text_box" name="password" placeholder="Password" />
</div> 
<div class="width_100 pt-2 text-center">
<input type="submit" class="btn btn-success" name="login" value="Login" />
</div>
</form>
</body>
</html>