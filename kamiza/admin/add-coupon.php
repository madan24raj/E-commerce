<?
require_once "headeradmin.php";
$obj=new user();
extract($_REQUEST);
$cat=$obj->getcategory();
if(!isset($_SESSION['admin'])){
header('Location:index.php');
}
if(isset($del)){
	$obj->delcoupon();
}
if(isset($updreward)){
	$obj->updreward();
}
if(isset($addcoupon)){
	$obj->addcoupons();
}
if(isset($active)){
	$obj->couponactive();
}


?>
<style>
.pd{
	float:left;
	padding:2%;
}

</style>
<script>
$(function(){
	
	$('#searchname').keyup(function(e) {
	var name = $(this).val();
	var email=$('#searchemail').val();
	var action="viewusersearch";
	var datastring={name:name,email:email,action:action};
	$.ajax({
		type:"post",
		url:"ajax_data.php",
		data:datastring,
		success:function(data){
			  	  $('#searchdata').html(data);
		}
	    
	});
	});
	$('#searchemail').keyup(function(e) {
	var email = $(this).val();
	var name=$('#searchname').val();
	var action="viewusersearch";
	var datastring={name:name,email:email,action:action};
	$.ajax({
		type:"post",
		url:"ajax_data.php",
		data:datastring,
		success:function(data){
			  	  $('#searchdata').html(data);
		}
	    
	});
	});
	
});

</script>


<div style="width:90%;margin:0 auto;">
<form method="post">
<div class=" col-xl-4 col-lg-4 col-md-6 col-sm-6 pd">
 <input type="text" id="ccode"  name="ccode" class="input_filed" placeholder="Coupon Code" required /> 
</div>
<div class=" col-xl-4 col-lg-4 col-md-6 col-sm-6 pd">
<input type="text" id="cpercet"  name="cpercent" class="input_filed" placeholder="Discount Percentage" required  /> 

</div>

 <div class=" col-xl-4 col-lg-4 col-md-6 col-sm-6 pd">

<input type="submit" value="Add Coupon"  name="addcoupon" class="btn btn-primary"  /> 

</div>
</form>

<div style="width:100%;float:left;">
<table class="table" id="searchdata">
<tr>
<th width="5%">#</th>
<th width="50%">Coupon Code</th>
<th width="20%">Discount Percentage</th>
<th width="15%">Active</th>
<th width="10%">Action</th>
</tr>
<?
$perpage = 10;
if(isset($page)){
$page = intval($page);
}
else {
$page = 1;
}
$calc = $perpage * $page;
$start = $calc - $perpage;
$sql=mysql_query("select * from coupons LIMIT $start,$perpage");
$rows = mysql_num_rows($sql);
if($rows){
while($pro=mysql_fetch_assoc($sql)){
	?>
<tr>
<input type="hidden" name="hidid" value="<?=$pro['Id']?>" />
<td style="vertical-align:middle"><?=$start+=1?></td>
<td style="vertical-align:middle"><?=$pro['coupon_code']?></td>
<td style="vertical-align:middle"><?=$pro['percent']?> %	</td>
<td style="vertical-align:middle"><? if($pro['isactive']==1){?> 
<a href="add-coupon.php?active=<?=$pro['isactive']?>&id=<?=$pro['Id']?>"><img src="../images/tick.png" width=25 height=25></a>
<?}else{?>
<a href="add-coupon.php?active=<?=$pro['isactive']?>&id=<?=$pro['Id']?>"><img src="../images/wrong.png" width=25 height=25></a>
<?}?></td>
<td style="vertical-align:middle"><a href="add-coupon.php?del=cou&cid=<?=$pro['Id']?>">Delete</a></td>

</tr>
<? }}?>
</table>
</div>

<div style="width:100%;float:left;">

<table  cellspacing="5" cellpadding="5" align="center">
<tbody>
<tr>
<td align="center">
<ul class="pagination">
<?php

if(isset($page))

{

$result = mysql_query("select Count(*) As Total from coupons");

$rows = mysql_num_rows($result);

if($rows)

{

$rs = mysql_fetch_assoc($result);

$total = $rs["Total"];

}

$totalPages = ceil($total / $perpage);

if($page <=1 ){

echo '<li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>';

}

else

{

$j = $page - 1;

echo '<li class="page-item"><a class="page-link" href="view-product.php?page='.$j.'">Previous</a></li>';

}

for($i=1; $i <= $totalPages; $i++)

{

if($i<>$page)

{

echo '<li class="page-item"><a class="page-link" href="view-product.php?page='.$i.'">'.$i.'</a></li>';

}

else

{

echo '<li class="page-item"><a class="page-link" href="#">'.$i.'</a></li>';

}

}

if($page == $totalPages )

{

echo '<li class="page-item disabled"><a class="page-link" href="#">Next</a></li>';

}

else

{

$j = $page + 1;

echo '<li class="page-item"><a class="page-link" href="view-product.php?page='.$j.'">Next</a></li>';

}

}

?></td>
</ul>

</tr>
</tbody>
</table>


</div>
</div>




</body>
</html>
