<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
require_once('header.php');
$obj=new user();
$pro=$obj->getrandproducts();
$ban=$obj->getmainbanners();
while($bann=mysqli_fetch_assoc($ban)){
	$banner[]=$bann;
}
$ban2=$obj->getsmallbanners();
while($bann2=mysqli_fetch_assoc($ban2)){
	$banner2[]=$bann2;
}
if(isset($logs)){
	echo "<script>$(function(){ $('#errloginmodal').modal('show'); 
	 }); </script>";
}
?>
<style>
.modal-confirm .btn {
        color: #fff;
        border-radius: 4px;
		background: #60c7c1;
		text-decoration: none;
		transition: all 0.4s;
        line-height: normal;
		min-width: 120px;
        border: none;
		min-height: 40px;
		border-radius: 3px;
		margin: 0 5px;
		outline: none !important;
    }
	.modal-confirm .btn-info {
        background: #c1c1c1;
    }
    .modal-confirm .btn-info:hover, .modal-confirm .btn-info:focus {
        background: #a8a8a8;
    }
    .modal-confirm .btn-danger {
        background: #f15e5e;
    }
    .modal-confirm .btn-danger:hover, .modal-confirm .btn-danger:focus {
        background: #ee3535;
    }
	.trigger-btn {
		display: inline-block;
		margin: 100px auto;
	}


.ff{
	float:left;
	padding:2%;
}

 .carousel-inner img {
      width: 100%;
      height: 100%;
  }
.carousel{
    height:150px!important;
}
@media(min-width:500px){
	    
		.carousel{
    height:500px!important;
}
@media (min-width:500px) {
    .sas{font-size: 2rem!important;}
}
@media (min-width:500px) {
    .as{font-size: 18px!important;}
}

</style>
<script>
$(function(){
	$('.carousel-indicators li:first-child').addClass('active');
	$('.carousel-inner div:first-child').addClass('active');
	
	
});
</script>
<div id="demo" class="carousel slide " data-ride="carousel">

  <!-- Indicators -->
  <ul class="carousel-indicators">
    <?$i=0;
	foreach($banner as $b){?>
	<li data-target="#demo" data-slide-to="<?=$i?>" ></li>
	<?$i++;}?>
  </ul>
  
  <!-- The slideshow -->
  <div class="carousel-inner">
  <?foreach($banner as $b){?>
    
	<div class="carousel-item">
	<a href="<?=$b['linkurl']?>">
      <img src="images/Banner/<?=$b['image']?>"  width="1100" height="500"></a>
    </div>
  <? }?>
  </div>
  
  <!-- Left and right controls -->
  <a class="carousel-control-prev" href="#demo" data-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </a>
  <a class="carousel-control-next" href="#demo" data-slide="next">
    <span class="carousel-control-next-icon"></span>
  </a>
</div>

<div class="secnd">
<div class="w-100">
<div class="text-center p-2">

<h2 class="pl-2 pr-2 mx-auto sas" style="font-size:16px;" >Our Products</h2>
<hr>

</div>
</div>
<div class="row scd" >
<?for($i=0;$i<4;$i++){?>
<div class="col-lg-6 col-xl-6 col-md-6 px-3 pb-5 col-sm-12">
<a href="<?=$banner2[$i]['linkurl']?>"><img src="images/Banner/<?=$banner2[$i]['image']?>" width="100%"></a>
</div>
<? }?>

</div>
</div>
<div class="thd">

<div class="text-center p-2">

<h2 class="pl-2 pr-2 mx-auto sas" style="font-size:16px;">Top Sellers</h2>
<hr>
</div>

<div class=" row scd" >
<?while($prod=mysqli_fetch_assoc($pro)){ ?>
<a class="a" href="produ2.php?code=<?=$prod['Prod_code']?>&color=<?=$prod['color']?>">
<div class="col-lg-3 col-xl-3 col-md-4 col-sm-4 float-left p-2" style="padding-bottom:30px!important;">
<div class="col-lg-12 col-xl-12 col-md-12 col-sm-12 float-left p-1 " >
<div style="width:250px;height:250px;margin:0 auto;">
<img src="images/Products/<?=$prod['image1']?>" width="100%" height="100%" >
</div>

<div class="text-center col-lg-12 col-xl-12 col-md-12 col-sm-12 float-left p-1">

<span style="font-size:16px;color:#757070;font-weight:bold;"><?=$prod['Name']?></span>
<div style="font-size:16px;">
<? echo '<i  class="fa fa-inr"></i><b> '.$prod['Price'].'</b>'; ?>
</div>
</div>
</a>
</div>
</div>
<?}?>
</div>

<div id="errloginmodal" class="modal fade cm2">
	<div class="modal-dialog modal-confirm">
		<div class="modal-content">
		
			<div class="modal-body">
				<p style="color:#000;font-size:16px;text-align:center;" class="paramsg2" id="paramsg2">Invalid Username / Password</p>
			</div>
			
		</div>
	</div>
</div>
<?
require_once "footer.php";
?>
</body>
</html>