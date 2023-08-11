<?session_start();
ob_start();
ob_flush();
error_reporting(1);?>
<html>
<head>
<title>Kamiza</title>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <!--script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script-->
<!--script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script-->
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  
    <script src="js/jquery.elevateZoom-3.0.8.min.js"></script>
	 <script src="js/jquery.elevatezoom.js"></script>
       <link rel="stylesheet" href="css/style.css">
       <link rel="stylesheet" href="css/style_own.css">
	   <script>
	   function lightbox_open(){
	document.getElementById('loginform').style.display='block';
	document.getElementById('light').style.display='block';
}

function lightbox_open1(){
	document.getElementById('loginform1').style.display='block';
	document.getElementById('light1').style.display='block';
}

function lightbox_open2(){
	document.getElementById('loginform2').style.display='block';
	document.getElementById('light2').style.display='block';
}

function lightbox_close(){
	document.getElementById('light').style.display='none';
	document.getElementById('light1').style.display='none';
	document.getElementById('light2').style.display='none';
	document.getElementById('loginform').style.display='none';
}
	   $(document).ready(function(){
 

	   $(".register").click(function() {
     var h = $("body").height() + 'px';
     $("#black_overlay").css({"height":h,"display":"block","z-index":"5"});
     $(".added").css('display','block');
  });
 
  $(".close").click(function() {
     $(".added").css('display','none');
     $("#black_overlay").css("display","none");
  });

	  

	   
      $.ajax({
        type:'post',
        url:'store_items.php',
        data:{
          total_cart_items:"totalitems",
		  headercart:"header"
        },
        success:function(response) {
          $('#total_items').html(response);
        }
      });

    });
	   </script>
	 </head>
<?
require_once"Database/clsuser.php";
extract($_REQUEST);
$obj=new user();
$men=$obj->getsubcategory(1);
$women=$obj->getsubcategory(2);
$unisex=$obj->getsubcategory(3);
if(isset($signin)){
	$obj->login();
}

?>
<style>
#total_items{
	font-size:12px;
	background:#ff0000;
	color:#fff;
	padding:0 5px;
	margin: -5px 0 10px 20px;
	border-radius:10px;
	vertical-align:top;
	position:absolute;
}
.modal-open{
	padding-right:0!important;
	overflow:inherit!important;
}
@media(min-width:500px)
{
	.navbar-toggler{
		display:none;
	}
}

@media(max-width:500px)
{

       .dropbtn{
           
             font-size: 14px;

            }

	.dd{
	margin-top:0!important;
	}
	.tt{
		margin-top:0!important;
	
	}
		
	.ft{
		float:left!important;
		padding:0!important;
	}
	.mll{
		    margin-top: .5rem!important;
	}
	.navbar-nav {
    display: -webkit-box;
    display: -ms-flexbox;
    /* display: flex; */
    -webkit-box-orient: horizontal;
	}
	.pp{
		padding:0!important;
		padding-right:16px!important;
	}
	.fm{
		
		padding:0!important;
	}
	.wis{
	    margin-left: 1%;
            width: 65%!important;
            float:left!important;
}
	.car{
       	   margin-left:0!important;
           width: 34%!important;
           float:right!important;
	}
}
@media(max-width:380px)
{
	.fm{
		width:50%;
		padding:0!important;
	}
	.rm{
		width:50%!important;
	}

}

</style>
<body style="padding-right:0!important;height:auto;overflow:inherit!important;">
<div id="black_overlay" style="width: 100%; background: #333; position:absolute;opacity:0.8;" > </div>
<div class="added">
    <div class="close_btn"><a class="close" href="#" style="color:#000;"> &curren; &nbsp; &nbsp; &nbsp; &nbsp; </a></div>
    <div class="login">
        <div class="new_user">Registered User Login</div>
   <form method="post">
	<input type="text" placeholder="Username" id="username" class="input_filed" name="username">  
	<input type="password" placeholder="Password" id="password" class="input_filed" name="password"> 
    <!--a href="../forgotpassword.php?keepThis=true&amp;TB_iframe=true&amp;height=200&amp;width=1000" title="Edit Links" style="text-decoration:none; color:#007FAA; margin-left: 8%;float: left;margin-top: 5%; font-size: 11px;" class="thickbox close">Forgot Password?</a-->
   <input type="submit" name="signin" id="signin" value="Sign in" class="btn btn-success" style="margin-top:10%;padding:2%;background-color:#28a745;text-align:center;"/>
    </form>
    <div class="line"></div>
    <div class="new_user">New user <a href="register.php" style="color:#ff590a">Register Here</a></div>
</div>
</div>
<div class="p-1 w-100" style="background-color:#112655;height:auto;">
<div class="wraper row">
<? if(isset($_SESSION['id'])) {
	?>
<style>
@media(max-width:400px){
.img-fluid {
    width: 100%!important;
}
</style>
<div class="col-xl-4 col-md-7 col-5 pl-2 ">
<?} else { ?>
<div class="col-xl-4 col-md-4 col-9 pl-2 ">
<? } ?>
<a href="index.php"><img class="img-fluid" src="images/Kamiza-Collection-Logo.png" width="auto" height="auto" /></a>
</div>
<? if( isset($_SESSION['id'])){?>
  <div class="col-xl-5 col-md-4 col-8 d-none d-lg-block mt-4">
<? } else { ?>
<div class="col-xl-7 col-md-6 col-5 mt-3 d-none d-md-block"> <? } ?>
<input class="float-right" style="width:130px;" type="text" name="search" id="search" placeholder="Track Order">
  </div>


<? if(isset($_SESSION['id'])) {
	?>
<div class="col-xl-3 col-md-5 col-7  tt"> <?  } else {     ?>
<div class="col-xl-1 col-md-2 col-3 mt-3 ">
<? } ?>

<? if(!isset($_SESSION['id'])){ ?>
	
<a href="#" class="float-right register p-2 pl-4" style="margin-top: -3px;margin-right: -10px;"><img  width="80px;" src="images/Login.png"></a>

<?}else{?>
<div class="col-xl-12 col-lg-12 col-md-12 col-12 float-right ft">		
<?echo '<a class="float-left ft mt-1"><font style="font-size:11px;color:#fff;margin-left:-10px;">Hi</font> <b style="color:#ffcc66;">'.ucfirst($_SESSION['name']).'</b></a>';?>
</div>
<div class="col-xl-12 col-lg-12 col-md-12 col-12 ft float-right mll">
<a href="wishlist.php" class="col-12 col-xl-6 col-lg-6 col-md-7 float-left p-2 "style="margin-top: -5px;margin-left:-20px;"><span style="color:fff">My Account</span></a>
<a href="logout.php" class="col-12 col-xl-6 col-lg-6 col-md-6  float-right p-2" style="margin-top: -3px;margin-right: -10px;"><img  width="70px;" src="images/logout.png"></a> 
	
</div>

<?}?>
</div>


</div>

</div>
  
</div>

<div class="w-100 menu wraper">

<nav class="navbar navbar-expand-sm ">
  <!-- Brand -->


  <!-- Links -->
   <div class="col-xl-8 col-md-8  col-8 col-sm-7 float-right fm mx-auto my-auto " >
  
  <ul class="navbar-nav float-left" style="margin-left:10%;">
   <li class="nav-item dropdown pp">
      <a id="b1" class="nav-link dropbtn dropdown-toggle" href="#" id="navbardrop" >
        <b>MEN</b>
      </a>
      <div  class="dropdown-content">
      <?while($sql=mysqli_fetch_assoc($men)){?>
		<a class="dropdown-item" href="products.php?id=<?=$sql['Id']?>"><?=$sql['Name']?></a>
        
	  <? }?>
      </div>
    </li>
    <li class="nav-item dropdown pp">
      <a class="nav-link dropbtn dropdown-toggle" href="#" id="navbardrop">
        <b>WOMEN</b>
      </a>
      <div class="dropdown-content">
        <?while($sql=mysqli_fetch_assoc($women)){?>
		<a class="dropdown-item" href="products.php?id=<?=$sql['Id']?>"><?=$sql['Name']?></a>
        
	  <? }?>
      </div>
    </li>

    <!-- Dropdown -->
    <li class="nav-item dropdown pp">
      <a class="nav-link dropbtn dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
        <b>UNISEX</b>
      </a>
      <div class="dropdown-content">
       <?while($sql=mysqli_fetch_assoc($unisex)){?>
		<a class="dropdown-item" href="products.php?id=<?=$sql['Id']?>"><?=$sql['Name']?></a>
        
	  <? }?>
      </div>
    </li>
  </ul>
  
  </div>
  <div class="col-xl-4 col-md-4 col-4  col-sm-4  rm float-right ">
  <div class="w-50 wis" style="float:left;"><? if(isset($_SESSION['id'])){?><a href="wishlist.php" class="float-right" style="padding:6px;"><img src="images/Wish-Icon.png" id="imgwish" width="30px"></a><?}else{?><a href="#" class="register float-right" style="padding:6px;"><img src="images/Wish-Icon.png" width="30px"></a><?}?></div>
  <div class="w-25 float-right  car my-auto" >
  <a href="cart.php" class="float-left" style="padding:6px;"><span id="total_items"></span><img id="cartimg" src="images/cart-icon.png" width="30px"></a>
  </div>
  </div>
</nav>
</div>



<div class="logmess" style="display: none;">
    <div class="close_btn"><a class="close" href="#" style="color:#000;">Close <i class="fa fa-times-circle" aria-hidden="true"></i></a></div>
    <div class="login">
        <div class="new_user" style="color:#ff590a">You have already logged in CNE, logout and try again.</div>
</div>
</div>
