<?
require_once "headeradmin.php";
$obj=new user();
extract($_REQUEST);
if(!isset($_SESSION['admin'])){
header('Location:index.php');
}
$cat=$obj->getcategory();

if(isset($del)){
	$obj->delproduct();
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
	
	$('#pcode').keyup(function(e) {
	var prtcode = $(this).val();
	var catid=$('#cat').val();
			var action="productsearch";
			var datastring={prtcode:prtcode,catid:catid,action:action};
	$.ajax({
		type:"post",
		url:"ajax_data.php",
		data:datastring,
		success:function(data){
			  	  $('#searchdata').html(data);
		}
	    
	});
	});
	$('#cat').change(function() {
		var prtcode = $('#prtcode').val();
	var catid=$(this).val();
			var action="productsearch";
			var datastring={prtcode:prtcode,catid:catid,action:action};
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


<div style="width:70%;margin:0 auto;">

<div class=" col-xl-4 col-lg-4 col-md-6 col-sm-6 pd">

 <input type="text" id="pcode"  name="pcode" class="input_filed" placeholder="Search by Product Code" /> 
</div>
<div class=" col-xl-4 col-lg-4 col-md-6 col-sm-6 pd">

<select id="cat" name="cat" class="input_filed" required>
<option value="">Search by Category</option>
<? foreach($cat as $key=>$value)
{
?>
<option value="<?=$key?>"><?=$value?></option>
<? }?>
</select>

</div>
 

<div style="width:100%;float:left;">
<table class="table" id="searchdata">
<tr>
<th width="5%">#</th>
<th width="10%">Code</th>
<th width="25%">Product Name</th>
<th width="15%">Category</th>
<th width="20%">Sub-Category</th>
<th width="20%">Sub-Sub-Category</th>
<th width="5%">Action</th>
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
$sql=mysql_query("select * from product order by Cat_id ASC LIMIT $start,$perpage");
$rows = mysql_num_rows($sql);
if($rows){
while($pro=mysql_fetch_assoc($sql)){
	$cat=$obj->getcategoryname($pro['Cat_id']);
	$sub=$obj->getcategoryname($pro['Subcat_id']);
	$subsub=$obj->getcategoryname($pro['Subsubcat_id']);
	?>
<tr>
<td><?=$start+=1?></td>
<td><?=$pro['Prod_code']?></td>
<td><?=$pro['Name']?></td>
<td><?=$cat['Name']?></td>
<td><?=$sub['Name']?></td>
<td><?=$subsub['Name']?></td>
<td><a href="update-product.php?id=<?=$pro['Id']?>">Update</a>&nbsp;<a href="view-product.php?id=<?=$pro['Id']?>&del=cat">Delete</a></td>
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

$result = mysql_query("select Count(*) As Total from product");

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
