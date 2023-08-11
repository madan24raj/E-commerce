<?php


require_once("header.php");
$obj=new user();
extract($_REQUEST);
	$name=$obj->getcategoryname($id);
	
	$catname=$obj->getcategoryname($name['c_id']);
	
	$pro=$obj->getproductsbycategory($id);
	$sub=$obj->getsubsubcategory($id);
	
	$su=array();
	while($sub1=mysqli_fetch_assoc($sub)){
		$su[]=$sub1;
	}

	?>
<style>
.open {
    max-height: 300px;
    opacity: 1;
}
.dropup .dropdown-content {
  top: auto;
  bottom: 100%;
  margin-bottom: .125rem;
}

 a{
	text-decoration:none;
	color:#06203c;
}
.nav-link:hover{
	
	box-shadow:2px 2px #ccc;
	
}
.headr{
	padding:2%;
	width:100%;
	color:#234373;
}
.active{
	background-color:#f5f4f4;
}
@media(max-width:500px){
	.tb{
		width:100%!important;
	}
	.dp{
	position:relative!important;
	}
.brd{
 width:100%!important;
 text-align:center;
}
.tp{
 width:100%!important;
}
.m{
 margin-left:9%;
}
}
.d1{
	width:100%;
	background-color:#ccc;
	opacity:.9;
}
.dd{
	margin:30%;
}
</style>
<script>
    $(function(){
        <? if(isset($tab)){?>
       var tab="<?=$tab?>";
       var count=<? echo count($su);?>;
       
       for(var i=0;i<count;i++){
           $('#all').removeClass('in active');
           $('#nav').removeClass('active');
            $('#nav'+i).removeClass('active');
           $('#item'+i).removeClass('in active');
       }
       
       for(var i=0;i<count;i++){
       var n=$('#nav'+i).html();
      
       
       if(tab.toUpperCase()==n){
           $('#nav'+i).addClass('active');
           $('#item'+i).addClass('in active');
       }
       }
        <? }?>
        
    });
</script>
<div  style="width:90%;margin:0 auto;">
<div style="width:90%;float:left;margin:0 auto;">
<div style="width:20%;float:left;" class="p-2 brd"> <span style="font-size:12px;color:#007bff;margin-left:9%;"><?=$catname['Name']?> &raquo; <span style="color:#007bff!important;" ><?=$name['Name']?></span></div>
<div style="width:80%;float:left;" class="tp">
<h3 class="text-center p-2 m"> <?=strtoupper($name['Name'])?></h3>
</div>
</div>
<div class="headr d-md-block d-none" style="width:20%;float:left;margin-top:2%;border-right:1px #ccc dashed">


<ul class="nav flex-column" role="tablist">
    <li class="nav-item text-left">
        <a class="nav-link active" id="nav" data-toggle="tab" href="#all" role="tab"><b>ALL PRODUCTS</b></a>
    </li>
   
  <?$i=0;
foreach($su as $s){?>
  <li class="nav-item text-left">
    <a class="nav-link nn" id="nav<?=$i?>" style="font-weight:bold;" href="#item<?=$i?>" role="tab" data-toggle="tab"><?=strtoupper($s['Name'])?></a>
  </li>
  <?$i++; }?>
  
</ul>

</div>
<div class="tab-content tb" style="width:80%;float:left;">
<div role="tabpanel" class="tab-pane in active" id="all">
<?$no=mysqli_num_rows($pro);
if(empty($no)){?>
	<div class="col-lg-12 col-xl-12 col-md-12 col-sm-12 text-center p-4" >
	<img src="images/noproduct.png" width="auto" />
	</div>
<?}else{
while($prod=mysqli_fetch_assoc($pro)){ ?>
<a class="a" href="produ2.php?code=<?=$prod['Prod_code']?>&color=<?=$prod['color']?>">
<div class="col-lg-4 col-xl-4 col-md-6 col-sm-6 float-left p-4" style="box-shadow: 0px 18px 10px 10px whitesmoke"; >
<div class="col-lg-12 col-xl-12 col-md-12 col-sm-12 float-left p-1 " >
<div style="width:250px;height:250px;margin:0 auto;">
<img src="images/Products/<?=$prod['image1']?>" width="100%" height="100%">
</div>


<div class="text-center col-lg-12 col-xl-12 col-md-12 col-sm-12 float-left p-1" style="height:50px;" >

<span style="font-size:16px;color:#757070;font-weight:bold;"><?=$prod['Name']?></span>
<div  style="font-size:16px;color:#000;">
<? echo '<i  class="fa fa-inr"></i> <b>'.$prod['Price'].'</b>'; ?>
</div>
</div>
</a>
</div>
</div>
<?}}?>
</div>

<?$i=0;

foreach($su as $s){?>
<div role="tabpanel" class="tab-pane" id="item<?=$i?>">
<?$sql=$obj->getproductsbysubsub($s['Id']);
$no=mysqli_num_rows($sql);
if(empty($no)){?>
	<div class="col-lg-12 col-xl-12 col-md-12 col-sm-12 text-center float-left p-2" >
	<img src="images/noproduct.png" class="img-fluid" width="auto" />
	</div>
<?}else{
while($prod=mysqli_fetch_assoc($sql)){ ?>
<a class="a" href="produ2.php?code=<?=$prod['Prod_code']?>&color=<?=$prod['color']?>">
<div class="col-lg-4 col-xl-4 col-md-6 col-sm-6 float-left p-4" >
<div class="col-lg-12 col-xl-12 col-md-12 col-sm-12 float-left p-1 " >
<div style="width:250px;height:250px;margin:0 auto;">
<img src="images/Products/<?=$prod['image1']?>" width="100%" height="100%">
</div>


<div class="text-center col-lg-12 col-xl-12 col-md-12 col-sm-12 float-left p-1" style="height:50px;">

<span style="font-size:16px;color:#757070;font-weight:bold;"><?=$prod['Name']?></span>
<div  style="font-size:16px;color:#000;">
<? echo '<i  class="fa fa-inr"></i> <b>'.$prod['Price'].'</b>'; ?>
</div>
</div>
</a>
</div>
</div>
<?}}?>
</div>

<?$i++;}?>

</div>
</div>


<nav class="d-md-none d-block  navbar fixed-bottom" >
    <div class="container">
      <div class="btn-group dropdown mx-auto d1 py-2">
	
        <a  id="b1" class=" dropbtn dropdown-toggle  dd"  href="#" id="navbardrop" >
        <b><?=strtoupper($name['Name'])?> TYPES</b>
      </a>
	
        <div class="dropdown-content open dp" style="opacity:0.9;min-width:343px!important;">
          <!-- Dropdown menu links -->
         <ul class="nav " id="di" >
    <li class="col-12 float-left text-center ">
        <a class=" text-center  active" id="nav cl" data-toggle="tab" href="#all" ><b>ALL PRODUCTS</b></a>
    </li>
   
  <?$i=0;
foreach($su as $s){?>
  <li class="col-12 float-left text-center"> 
	<a class=" text-center nn " id="nav<?=$i?> cl" style="font-weight:bold;" href="#item<?=$i?>"  data-toggle="tab"><?=strtoupper($s['Name'])?></a>
  </li>
  
  <?$i++; }?>
   
   <a class=" text-center nn " id="nav cl"  href="#item<?=$i?>"  data-toggle="tab"></a>
  
</ul>
        </div>
      </div>
     
    </div>
	
  </nav>
<footer>
<?require_once"footer.php";
?>
</footer>
<script>

$(document).ready(function(){
 $('a.dd').click(function(){
	$(this).next('.open').fadeIn(); 
	   $('.dd').hide();
	return false; 
	
}); 

$('html').click(function(e) {
	$('.open').hide();
	 $('.dd').show();
});
	
});
  </script>
</body>
</html>
