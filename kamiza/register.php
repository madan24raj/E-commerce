<? ob_start();

require_once"header.php";
?>


<?
require_once"Database/clsuser.php";
$obj=new user();
$states=$obj->states();
extract($_REQUEST);
if(isset($signup)){
	$ins=$obj->registration();
}
if(isset($signin)){
	$login=$obj->login();
}

?>
<script>
var emailflag=0;
	var mobflag=0;
	var pinflag=0;
$(function(){
	$('#pincode').keyup(function(e) {
		var pincode = $(this).val();
	if(pincode.length == 6 && $.isNumeric(pincode)) {
		$('#pincode').css('border','1px solid #a1a3a3');
		pinflag=0;
	}
	else{
		$("#pincode").css('border','2px solid #ff0000');
		pinflag=1;
	}
	});
	$('#email').keyup(function(e) {
		var email=$(this).val();
		 $.ajax({
        type:'post',
        url:'ajax_data.php',
        data:{
          email:email,
		  checkemail:"check"
        },
        success:function(response) {
            if(response==1){
				$("#email").css('border','2px solid #ff0000');
				emailflag=1;
			}else{
				$('#email').css('border','1px solid #a1a3a3');
				emailflag=0;
			}
        }
      });
	});
	
	$('#mobile').keyup(function(e) {
		var mobile=$(this).val();
		 $.ajax({
        type:'post',
        url:'ajax_data.php',
        data:{
          mobile:mobile,
		  checkmob:"check"
        },
        success:function(response) {
            if(response==1){
				$("#mobile").css('border','2px solid #ff0000');
				mobflag=1;
			}else{
				$('#mobile').css('border','1px solid #a1a3a3');
				mobflag=0;
			}
        }
      });
	});
	$('#cpass').keyup(function(e) {
		var password=$("#pass").val();
		var cpassword=$(this).val();
		if(password!=cpassword){
		$('#cpass').css('border','2px solid #ff0000');
		}
		else{
			$('#cpass').css('border','1px solid #a1a3a3');
		}
	});
});
function validation(){
var name = $("#name").val();
var email = $("#email").val();
var mobile = $("#mobile").val();
var pass=$('#pass').val();
var cpass=$('#cpass').val();

if (emailflag==1) {
alert("This email already registered");
return false;
}

else if (mobflag==1) {
alert("This Mobile already registered");
return false;
}else if(pass!=cpass){
	alert("Password does not match");
	return false;
}
else if(pinflag==1){
	alert("Enter a valid pincode");
	return false;
}else {
return true;
}
	}
</script>
<style>
@media(max-width:500px)
{
	.reg{
		border-right:0!important;
		border-bottom:1px solid #000!important;
	}
}
@media(max-width:800px)
{
	#wraper {
    width: 92%!important;
}	
}
</style>
<body>
<div id="wraper" style="width:88%;">
<div class="width_100" style="margin-top:20px;">
<div class="col-xl-8 col-lg-8 col-md-6 col-12 reg"  style="float:left;padding:1% 2%;border-right:1px solid #000;">
<h4>New User? Register here...</h4>
<div class="width_100" style="text-align:center; padding: 0px 0;">
   
<? 
if(isset($err)){
$msg="This Mailid/phone already registered";
$clr="Red";
}else if(isset($suc)){
	$msg=" Succesfully Registered. Log in to continue...";
	$clr="Green";
}
if(isset($err) || isset($suc)){
	echo '<b class="width_100" style="color:'.$clr.'">'.$msg.'</b>';
}
?>
</div>
<form method="post" id="form" onsubmit="return validation()">

<div class="col-xl-6 col-lg-6 col-md-12 col-12 float-left" style="text-align:center; padding: 10px 0;"><input type="text" id="name" name="name" placeholder="Name" class="input_filed" style=" width: 80%;" required /></div>
<div class="col-xl-6 col-lg-6 col-md-12 col-12 float-left" style="text-align:center; padding: 21px 0;"><b>Gender: &nbsp; </b>
<input type="radio" name="gender" value="Male"/> Male &nbsp; &nbsp; 
<input type="radio" name="gender" value="Female"/> Female &nbsp; &nbsp; 
<input type="radio" name="gender" value="Others"/> Others
</div>
<div class="col-xl-6 col-lg-6 col-md-12 col-12 float-left" style="text-align:center; padding: 10px 0;"><input type="email" id="email" name="email" placeholder="Email" class="input_filed" style=" width: 80%;" required /></div>
<div class="col-xl-6 col-lg-6 col-md-12 col-12 float-left" style="text-align:center; padding: 10px 0;"><input type="text" name="mob" id="mobile" placeholder="Mobile" class="input_filed" style=" width: 80%;" pattern="[6-9]{1}[0-9]{9}"/></div>
<div class="col-xl-6 col-lg-6 col-md-12 col-12 float-left" style="text-align:center; padding: 10px 0;"><input type="password" id="pass" name="pass" placeholder="Password" class="input_filed" style=" width: 80%;" required /></div>
<div class="col-xl-6 col-lg-6 col-md-12 col-12 float-left" style="text-align:center; padding: 10px 0;"><input type="password" id="cpass" name="conpass" placeholder="Confirm Password" class="input_filed" style=" width: 80%;" required /></div>

<div class="col-xl-6 col-lg-6 col-md-12 col-12 float-left" style="text-align:center; padding: 10px 0;"><input type="text" name="add" placeholder="Door no / Street" class="input_filed" style=" width: 80%;" required /></div>
<div class="col-xl-6 col-lg-6 col-md-12 col-12 float-left" style="text-align:center; padding: 10px 0;"><input type="text" name="area" placeholder="Area" class="input_filed" style=" width: 80%;" required /></div>
<div class="col-xl-6 col-lg-6 col-md-12 col-12 float-left" style="text-align:center; padding: 10px 0;"><input type="text" name="city" placeholder="City" class="input_filed" style=" width: 80%;" required /></div>
<div class="col-xl-6 col-lg-6 col-md-12 col-12 float-left" style="text-align:center; padding: 10px 0;"><input type="text" id="pincode" name="pincode" placeholder="Pincode" class="input_filed" style=" width: 80%;" required /></div>
<div class="col-xl-6 col-lg-6 col-md-12 col-12 float-left" style="text-align:center; padding: 10px 0;">
<select name="state" class="input_filed" required style=" width: 80%;">
<option value="">Select State</option>
<? foreach($states as $key=>$val){
echo '<option value="'.$key.'">'.$val.'</option>';	
}?>
</select>
</div>
<div class="col-xl-6 col-lg-6 col-md-12 col-12 float-left" style="text-align:center;"><input type="submit" onclick="return validation()" id="signup" name="signup" value="Register Now!" class="btn btn-primary" style="margin:10px 0 0 0px; width: 50%;background-color:#007bff;"/></div>
</form>

</div>
<div class="col-xl-4 col-lg-4 col-md-6 col-12"  style=" float:left;padding: 1% 2%;">
    <h4>Registered Users Login</h4>
<form method="post">
<div class="w-100" style="text-align:center; padding: 10px 0;"><input type="text" name="username" placeholder="Email" class="input_filed" style=" width: 70%;"/></div>
<div class="w-100" style="text-align:center; padding: 10px 0;"><input type="password" name="password" placeholder="Password" class="input_filed" style=" width: 70%;"/></div>
<div class="w-100" style="text-align:center;" ><input type="submit" name="signin" value="Sign In" class="btn" style="margin:20px 0 0 0; width: 50%;background-color:#17a2b8;"/></div>
</form>
</div>
</div>
</div>
<?require_once"footer.php";
?>
</body>
</html>