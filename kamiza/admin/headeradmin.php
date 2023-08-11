<?
session_start();
?>
<html>
<head>
<title>Kamiza</title>
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
error_reporting(1);
require_once"../Database/clsuser.php";
extract($_REQUEST);
?>
<style>

::placeholder {
    color: #ccc;
    opacity: 1; /* Firefox */
}
#search{
background-image:url(images/search.png);   
background-position:right;   
background-repeat:no-repeat;  
padding:3px; 
padding-left:17px;
border-radius:12px;
width:50%;
}

.slide{
	width:100%;
	height:8px;
	background-color:#f92727;
}
@media(max-width:400px){
	#search{
		width:64%!important;
	}
	.img-fluid{
		width:80%;
	}
	.mob{
		padding-left:33%!important;
	}
}
.navbar-nav>.nav-item{
	margin-left:20px;
  border-right: 2px solid #3da6d8;
  border-radius:2px;
  line-height:20px;
	
}
.navbar-nav>.nav-item:last-child{
   border: none;
}
a.nav-link{
	margin-right:20px;
}
</style>

<body>
<div class="p-2 w-100" style="background-color:#112655;">
<div class="wraper row">
<div class="col-xl-6 pl-5">
<img class="img-fluid" src="../images/Kamiza-Collection-Logo.png" width="auto" height="auto" />
</div>
</div>
</div>
<div class="slide">
</div>
<div class="w-100" style="background-color:#fcfcfc;border-bottom:3px solid #3da6d8;" >
<nav class="navbar navbar-expand-sm  " style="width:100%;margin:0 auto;">
  <!-- Brand -->


  <!-- Links -->
  <div class="text-center col-xl-11 col-md-11 col-sm-12 float-right mx-auto mob" >
  <ul class="navbar-nav">
   <li class="nav-item dropdown pp">
      <a class="nav-link " href="add-category.php" >
        <b>Add Category</b>	
      </a>
    </li>

    <!-- Dropdown -->
    <li class="nav-item dropdown pp">
      <a class="nav-link " href="add-product.php" >
        <b>Add Product</b>
      </a>
    </li>
	    <li class="nav-item dropdown pp">
      <a class="nav-link " href="view-product.php" >
        <b>View Product</b>
      </a>
    </li>
	    
	<li class="nav-item dropdown pp">
      <a class="nav-link " href="add-banner.php" >
        <b>Add Banner</b>
      </a>
    </li>
<li class="nav-item dropdown pp">
      <a class="nav-link " href="view-user.php" >
        <b>View Users</b>
      </a>
    </li>
<li class="nav-item dropdown pp">
      <a class="nav-link " href="add-coupon.php" >
        <b>Add Coupons</b>
      </a>
    </li>
<li class="nav-item dropdown pp">
      <a class="nav-link " href="order-status.php" >
        <b>Order Status</b>
      </a>
    </li>
  </ul>
  </div>
  <div class="col-xl-1 col-md-1 col-sm-12">
  <div class="w-100 col-sm-6" style="float:right;">
  <a class="btn float-right" href="logout.php"><b>Log Out</b></a>
  </div>
  </div>
</nav>
</div>
