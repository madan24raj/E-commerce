<?
require_once "headeradmin.php";
$obj=new user();
extract($_REQUEST);
$cat=$obj->getcategory();
//$sql=$obj->getallcategories();
if(!isset($_SESSION['admin'])){
header('Location:index.php');
}
if(isset($suc) && $suc=='ins'){
	echo "<script>setTimeout(function() { alert('Added Successful'); }, 1500);</script>";
}
if(isset($suc) && $suc=='del'){
	echo "<script>alert('Category Deleted Successfully');</script>";
}
if(isset($del)){
	$obj->delcategory();
}
if(isset($submit)){

		$obj->addcategory();
	}
	if(isset($infoupd)){

		$SS=$obj->updateinfo();
	}

?>
<style>
.pd{
	float:left;
	padding:2%;
}
.don label{
	appearance:button;
	padding:10px;
	cursor:pointer;
	height:30px;
	width:30px;
	text-align:left;
	float:left;
}
input[name=color]{
	display:none;
}
input[type="radio"]:not(:checked)  {
    border: 0px #000 solid;
}

.don{
	list-style-type:none;
}
.don li{
	float:left;
	margin-right:5px;
}
.don label:hover{
border:2px solid #000;
}
</style>
<script>
$(function(){
	
	$('.infoupdate').click(function(){
		var info=$(this).parent().find('.hidinfo').val();
		var cat=$(this).parent().find('.catname').val();
		var sub=$(this).parent().find('.subname').val();
		
		var subid=$(this).parent().find('.subid').val();
		
		$('#updinfo').html(info);
		$('#prodname').html(cat+' &raquo; '+sub);
		$('#hidsubid').val(subid);;
		$('#dem').modal('show');
	});
	
	
	$('.color').click(function(){
	   
   
	if($(this).is(':checked')) {
		$(this).parent().css({'border':'2px #000 solid'});
		}
		
	});
	
	
	$('#cat').change(function() {
	var catid=this.value;
	var data=new Array();
	var action="categorysearch";

	var datastring={catid:catid,action:action};
	$.ajax({
		type:"post",
		url:"ajax_data.php",
		data:datastring,
		success:function(data){
			$('#sub').empty();
			 $('#sub').append('<option value="">--Select---</option>');
			resultObj = eval (data);
			
       for(var i=0;i<resultObj.length;i++){
	   var id=resultObj[i].split("~~~");
	   
	   $('#sub').append('<option value="'+id[0]+'">'+id[1]+'</option>');
          
		  }
		}
	    
	});
	});
	$('#sub').change(function() {
	var catid1=this.value;
	var data=new Array();
	var action="subcategorysearch";

	var datastring={catid1:catid1,action:action};
	$.ajax({
		type:"post",
		url:"ajax_data.php",
		data:datastring,
		success:function(data){
			$('#subsub').empty();
			 $('#subsub').append('<option value="">--Select---</option>');
			resultObj = eval (data);
			
       for(var i=0;i<resultObj.length;i++){
	   var id=resultObj[i].split("~~~");
	   
	   $('#subsub').append('<option value="'+id[0]+'">'+id[1]+'</option>');
          
		  }
		}
	    
	});
	});
	
		$('#prtcode').keyup(function(e) {	
		var prtcode = $(this).val();
			
			var req = 'retrieve.php?prtcode=' + prtcode;
			$.getJSON(req, null, function(data) {
				var sub=data.sub;
				var subsub1=data.subsub;
				$('#name').val(data.name);
				$('#cat').val(data.cat);
				$('#desc').val(data.desc);
				$('#price').val(data.price);
				
	
				
				
			/* sub category selection */
			var catid=$('#cat').val();
			var data=new Array();
			var action="categorysearch";
			var datastring={catid:catid,action:action};
	$.ajax({
		type:"post",
		url:"ajax_data.php",
		data:datastring,
		success:function(data){
			$('#sub').empty();
			 $('#sub').append('<option value="">--Select---</option>');
			resultObj = eval (data);
			
       for(var i=0;i<resultObj.length;i++){
	   var sel="";
	   var id=resultObj[i].split("~~~");
	   if(id[0]==sub){sel="selected";}else{sel="";}
	   $('#sub').append('<option value="'+id[0]+'" '+sel+'>'+id[1]+'</option>');
          
		  }
		  
		}
	    
	});
	
				
				/*subsubcategory selection */
			
			var catid1=sub;
			var data1=new Array();
			var action="subcategorysearch";
			var datastring1={catid1:catid1,action:action};
			$.ajax({
			type:"post",
		url:"ajax_data.php",
		data:datastring1,
		success:function(data1){
			$('#subsub').empty();
			 $('#subsub').append('<option value="">--Select---</option>');
			resultObj1 = eval (data1);
			for(var i=0;i<resultObj1.length;i++){
		   var sel="";
	   var id1=resultObj1[i].split("~~~");
	   if(id1[0]==subsub1){sel="selected";}else{sel="";}
	   $('#subsub').append('<option value="'+id1[0]+'" '+sel+'>'+id1[1]+'</option>');
		  }
		}
	    
	});

		
			
			});
	
		
	});
});

</script>


<div style="width:70%;margin:0 auto;">
<form action="#" method="post" name="prd" enctype="multipart/form-data">

<div class=" col-xl-4 col-lg-4 col-md-6 col-sm-6 pd">
<div><b>Select Category</b></div>
<select id="cat" name="cat" class="input_filed" required>
<option value="">--Select---</option>
<? foreach($cat as $key=>$value)
{
?>
<option value="<?=$key?>"><?=$value?></option>
<? }?>
</select>
</div>
<div class=" col-xl-4 col-lg-4 col-md-6 col-sm-6 pd">
<div><b>Select Sub-Category</b></div>
<select id="sub" name="sub" class="input_filed" >
<option value="">--Select---</option>

</select>
</div>


<div class=" col-xl-4 col-lg-4 col-md-6 col-sm-6 pd"> 
 <div><b> Name</b></div> 
 <input type="text" name="name"  class="input_filed"  /> 
 </div>
 

</br>

<div class=" col-xl-4 col-lg-4 col-md-6 col-sm-6 pd">
 <div><b> Info & Care</b></div> 
<textarea name="infocare" class="textarea"></textarea>  </div>
<div class=" col-xl-4 col-lg-4 col-md-6 col-sm-6 pd mt-5">
<input type="submit" name="submit" class="btn btn-primary" value="Submit"/>  </div>

</form>
<div style="width:100%;float:left;">
<table class="table">
<tr>
<th width="5%">#</th>
<th >Category</th>
<th >Sub-Category</th>
<th >Sub-Sub-Category</th>

<th >Action</th>
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
$sql=mysql_query("select c.infocare,ca.Id as catid,IFNULL(cat.Id,c.Id) as subid,IF(IFNULL(cat.Name,c.Name)=c.Name,0,c.Id) as subsubid,c.Id as ID,ca.Name as Category,IFNULL(cat.Name,c.Name) as sub,IF(IFNULL(cat.Name,c.Name)=c.Name,NULL,c.Name) as subsub  from category ca left join category c on c.c_id=ca.Id left join category cat on c.s_id=cat.Id  where c.c_id!=0 order by catid,subsub,sub LIMIT $start,$perpage");
$rows = mysql_num_rows($sql);

if($rows){
while($cat=mysql_fetch_assoc($sql)){
$subsub=($cat['sub']==$cat['subsub'])?"-":$cat['subsub'];?>
<tr>
<td style="vertical-align:middle;"><?=$start+=1?></td>
<td style="vertical-align:middle;"><?=$cat['Category']?></td>
<td style="vertical-align:middle;"><?=$cat['sub']?></td>
<td style="vertical-align:middle;"><?=$subsub?></td>
<td style="vertical-align:middle;"><? if(empty($subsub)){?><i style="cursor:pointer;" class="fa fa-info infoupdate"></i><? }?> &nbsp; &nbsp; &nbsp; <a href="add-category.php?id=<?=$cat['ID']?>&cid=<?=$cat['catid']?>&sid=<?=$cat['subid']?>&ssid=<?=$cat['subsubid']?>&del=cat">Delete</a>&nbsp;

 <input type="hidden" class="hidinfo" value="<?=$cat['infocare']?>" />
 <input type="hidden" class="catname" value="<?=$cat['Category']?>" />
 <input type="hidden" class="subname" value="<?=$cat['sub']?>" />
 <input type="hidden" class="catid" value="<?=$cat['catid']?>" />
 <input type="hidden" class="subid" value="<?=$cat['subid']?>" />
 <input type="hidden" class="subsubid" value="<?=$cat['subsubid']?>" />
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

$result = mysql_query("select Count(*) As Total from category");

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

echo '<li class="page-item"><a class="page-link" href="add-category.php?page='.$j.'">Previous</a></li>';

}

for($i=1; $i <= $totalPages; $i++)

{

if($i<>$page)

{

echo '<li class="page-item"><a class="page-link" href="add-category.php?page='.$i.'">'.$i.'</a></li>';

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

echo '<li class="page-item"><a class="page-link" href="add-category.php?page='.$j.'">Next</a></li>';

}

}

?></td>
</ul>

</tr>
</tbody>
</table>
  <div class="modal fade" id="dem">
    <div class="modal-dialog">
      <div class="modal-content">
      <div class="modal-header">
        
        <h6 class="modal-title">Info & Care for <span id="prodname"></span></h6>&nbsp;
		<button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
        
        <!-- Modal body -->
        <div class="modal-body text-center">
		<form method="post">
		
		<input type="hidden" name="hidsubid" id="hidsubid" />
		
          <textarea class="textarea" name="updinfo" id="updinfo"></textarea><br/><br/><input type="submit" name="infoupd" class="btn btn-success"/></form>
        </div>
        
       
        
      </div>
    </div>
    </div>

</div>

</div>




</body>
</html>
